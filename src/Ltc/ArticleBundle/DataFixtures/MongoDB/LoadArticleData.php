<?php

namespace Ltc\ArticleBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

use Ltc\ArticleBundle\Document\Article;
use Ltc\ImageBundle\Document\Image;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use DateTime;

class LoadArticleData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    const ARTICLE_TABLE     = 'pap_article';
    const TAG_TABLE         = 'pap_tag';
    const ARTICLE_TAG_TABLE = 'pap_article_tag';
    const PUBLICATION_TABLE = 'pap_publication';

    protected $dossiers = array(
        2 => 'textes',
        3 => 'invites',
        4 => 'outils',
        5 => 'visuels',
        6 => 'chantiers'
    );
    protected $categoryRepository;
    protected $userRepository;
    protected $userManager;
    protected $articles;
    protected $articleTags;
    protected $tags;
    protected $publications;

    public function getOrder()
    {
        return 10;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->userManager        = $container->get('fos_user.user_manager');
        $this->userRepository     = $container->get('ltc_user.repository.user');
        $this->articles           = $container->get('ltc_import.unserializer')->unserialize(self::ARTICLE_TABLE);
        $this->categoryRepository = $container->get('ltc_article.repository.category');
        $this->tagRepository      = $container->get('ltc_tag.repository.tag');
        $this->articleTags        = $container->get('ltc_import.unserializer')->unserialize(self::ARTICLE_TAG_TABLE);
        $this->tags               = $container->get('ltc_import.unserializer')->unserialize(self::TAG_TABLE);
        $this->publications       = $container->get('ltc_import.unserializer')->unserialize(self::PUBLICATION_TABLE);
    }

    public function load($manager)
    {
        $articleTags = $this->prepareArticleTags();

        foreach ($this->dossiers as $slug) {
            $this->categoriesBySlug[$slug] = $this->categoryRepository->findOneBySlug($slug);
        }
        $categoriesBySlug = $this->categoryRepository->findAllIndexBySlug();
        $usersByUsername = $this->userRepository->findAllIndexByUsernameCanonical();
        $publications = $this->preparePublications();

        foreach ($this->articles as $a) {
            if (!isset($this->dossiers[$a['dossier_id']])) {
                continue;
            }
            $categorySlug = $this->dossiers[$a['dossier_id']];
            $category = $categoriesBySlug[$categorySlug];

            $o = new Article();
            $o->setCategory($category);
            $o->setCreatedAt(new DateTime($a['created_at']));
            $o->setUpdatedAt(new DateTime($a['updated_at']));
            $o->setSummary($a['resume']);
            $o->setBody($a['description']);
            $o->setTitle($a['nom']);
            if (!empty($a['strip'])) {
                $o->setSlug($a['strip']);
            }
            $o->setReference($a['reference']);
            $o->setUrl($a['lien']);
            if (isset($a['auteur'])) {
                $o->setAuthorName($a['auteur']);
                $o->setAuthorBio($a['qualite']);
            }
            if (isset($a['image'])) {
                $image = $this->createImage($a['image'], $a['legende']);
                $o->setImage($image);
            }
            if (isset($articleTags[$a['id']])) {
                $o->setTags(new ArrayCollection($articleTags[$a['id']]));
            }
            if ($a['is_approved']) {
                $o->setIsPublished(true);
                $o->setPublishedAt($o->getCreatedAt());
            } else {
                $o->setIsPublished(false);
            }
            $o->setPublicationDate($a['publication']);
            if (isset($publications[$a['id']])) {
                $o->setRelatedPublications($publications[$a['id']]);
            }
            $manager->persist($o);
        }
        $manager->flush();
    }

    protected function prepareArticleTags()
    {
        $tagsBySlug = $this->tagRepository->findAllIndexBySlug();
        $articleTags = array();
        $tagsById = array();
        foreach ($this->tags as $tag) {
            $tagsById[$tag['id']] = $tagsBySlug[$tag['strip']];
        }
        foreach ($this->articleTags as $at) {
            $articleId = $at['article_id'];
            if (!isset($articleTags[$articleId])) {
                $articleTags[$articleId] = array();
            }
            $articleTags[$articleId][] = $tagsById[$at['tag_id']];
        }

        return $articleTags;
    }

    protected function preparePublications()
    {
        $publicationsById = array();
        foreach ($this->publications as $publication) {
            $string = sprintf('[%s](%s)', $publication['nom'], $publication['url']);
            if (isset($publicationsById[$publication['article_id']])) {
                $publicationsById[$publication['article_id']] .= "\n".$string;
            } else {
                $publicationsById[$publication['article_id']] = $string;
            }
        }

        return $publicationsById;
    }

    protected function createImage($filename, $legend)
    {
        $image = new Image();
        $image->setLegend($legend);
        $file = new File(__DIR__.'/../fixture.jpg');
        $image->setFile($file);

        return $image;
    }
}
