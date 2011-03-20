<?php

namespace Ltc\ImportBundle\Db;

use Ltc\ArticleBundle\Document\Article;
use DateTime;

class ArticleImporter extends AbstractImporter
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

    public function setUserManager($userManager)
    {
        $this->userManager = $userManager;
    }

    public function import()
    {
        $categories = $this->prepareCategories();
        $mainAuthor = $this->getMainAuthor();
        $arrays = $this->mysql->tableToArray(self::TABLE);

        foreach ($arrays as $a) {
            if (!isset($categories[$a['dossier_id']])) {
                continue;
            }
            var_dump($a);die;
            $o = new Article();
            $o->setCategory($categories[$a['dossier_id']]);
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
                $user = $mainAuthor;
            }
            $o->setAuthor($user);
            $this->persist($o);
        }

        $this->flush();
    }

    protected function prepareCategories()
    {
        $repo = $this->manager->getRepository('Ltc\ArticleBundle\Document\Category');
        $dossiers = array();
        foreach ($this->dossiers as $id => $code) {
            $dossiers[$id] = $repo->findOneBySlug($code);
            if (empty($dossiers[$id])) {
                throw new \Exception('Missing category for code='.$code);
            }
        }

        return $dossiers;
    }

    protected function getMainAuthor()
    {
        return $this->userManager->findUserByUsername('pascal');
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
