<?php

namespace Ltc\ArticleBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

use Ltc\ArticleBundle\Document\Category;

class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    protected $manager;

    public function getOrder()
    {
        return 8;
    }

    public function setContainer(ContainerInterface $container = null)
    {
    }

    public function load($manager)
    {
        $this->manager = $manager;

        $this->create('Textes');
        $this->create('Invites');
        $this->create('Outils');
        $this->create('Visuels');
        $this->create('Chantiers');

        $manager->flush();
    }

    protected function create($title)
    {
        $category = new Category();
        $category->setTitle($title);
        $this->manager->persist($category);
    }
}
