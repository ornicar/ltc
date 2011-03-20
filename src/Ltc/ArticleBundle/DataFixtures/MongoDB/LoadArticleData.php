<?php

namespace Ltc\ArticleBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

use Ltc\ArticleBundle\Document\Article;
use DateTime;

class LoadArticleData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    const TABLE = 'pap_article';

    protected $dossiers = array(
        2 => 'textes',
        3 => 'invites',
        4 => 'outils',
        5 => 'visuels',
        6 => 'chantiers'
    );
    protected $userManager;
    protected $data;

    public function getOrder()
    {
        return 10;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->userManager  = $container->get('fos_user.user_manager');
        $this->data = $container->get('ltc_import.unserializer')->unserialize(self::TABLE);
    }

    public function load($manager)
    {
        foreach ($this->data as $a) {
            if (!isset($this->dossiers[$a['dossier_id']])) {
                continue;
            }
            $category = $this->getReference('category-'.$this->dossiers[$a['dossier_id']]);
            $o = new Article();
            $o->setCategory($category);
            $o->setCreatedAt(new DateTime($a['created_at']));
            $o->setUpdatedAt(new DateTime($a['updated_at']));
            $o->setTitle($a['nom']);
            $o->setSummary($a['resume']);
            $o->setBody($a['description']);
            $o->setTitle($a['nom']);
            $o->setSlug($a['strip']);
            $o->setReference($a['reference']);
            $o->setUrl($a['lien']);

            if (isset($a['author'])) {
                $user = $this->createUser($a['author'], $a['qualite']);
            } else {
                $user = $this->getReference('user-pascal');
            }
            $o->setAuthor($user);
            $manager->persist($o);
        }
        $manager->flush();
    }

    protected function createUser($userFullName)
    {
        $user = $this->userManager->createUser();
        $user->setUsername($userFullName);
        $user->setFullName($userFullName);
        $user->setBio($bio);
        $user->setPlainPassword(base_convert(mt_rand(0x1D39D3E06400000, 0x41C21CB8E0FFFFFF), 10, 36));
        $this->userManager->updateUser();

        return $user;
    }
}
