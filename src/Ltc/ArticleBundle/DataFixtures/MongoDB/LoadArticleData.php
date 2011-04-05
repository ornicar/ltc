<?php

namespace Ltc\ArticleBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

use Ltc\BlogBundle\Document\BlogEntry;
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
        1 => 'blog',
        2 => 'didactique-information',
        3 => 'invites',
        4 => 'outils',
        5 => 'visuels',
        6 => 'chantiers',
        99 => 'identite-professionnelle',
    );
    protected $categoryRepository;
    protected $userRepository;
    protected $userManager;
    protected $articles;
    protected $articleTags;
    protected $tags;
    protected $publications;
    protected $documentRoot;
    protected $importRoot;

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
        $this->documentRoot       = $container->getParameter('document_root');
        $this->importRoot         = $container->getParameter('kernel.root_dir').'/import';
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
            if (in_array($a['id'], array(2347, 2337, 2363, 2356))) {
                $a['dossier_id'] = 99;
            }
            if (!isset($this->dossiers[$a['dossier_id']])) {
                continue;
            }
            $categorySlug = $this->dossiers[$a['dossier_id']];
            if ('blog' === $categorySlug) {
                $o = new BlogEntry();
            } else {
                $o = new Article();
                $o->setCategory($categoriesBySlug[$categorySlug]);
                $o->setUrl($a['lien']);
                $o->setPublicationDate($a['publication']);
            }
            $o->setCreatedAt(new DateTime($a['created_at']));
            $o->setUpdatedAt(new DateTime($a['updated_at']));
            $o->setSummary($a['resume']);
            $o->setBody($a['description']);
            $o->setTitle($a['nom']);
            if (!empty($a['strip'])) {
                $o->setSlug($a['strip']);
            }
            $o->setReference($a['reference']);
            if (isset($a['auteur'])) {
                $o->setAuthorName($a['auteur']);
                $o->setAuthorBio($a['qualite']);
            }
            if (isset($a['image'])) {
                if ($image = $this->createImage($a['image'], $a['legende'])) {
                    $o->setImage($image);
                }
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
        $fixturePath = $this->importRoot.'/uploads/article/'.$filename;
        $webPath = '/uploads/'.$filename;
        if (!file_exists($this->documentRoot.$webPath)) {
            if (!@copy($fixturePath, $this->documentRoot.$webPath)) {
                print 'Missing image '.$filename."\n";
                return false;
            }
        }
        $image = new Image();
        $image->setLegend($legend);
        $image->setPath($webPath);

        return $image;
    }
}
