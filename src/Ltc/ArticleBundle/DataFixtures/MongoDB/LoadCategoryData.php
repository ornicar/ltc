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

        $this->create('Didactique de l\'Info', 'didactique-information');
        $this->create('Identité professionnelle');
        $this->create('Chantiers');
        $this->create('Outils');

        $manager->flush();
    }

    protected function create($title, $slug = null)
    {
        $category = new Category();
        $category->setTitle($title);
        if ($slug) {
            $category->setSlug($slug);
        }
        $this->manager->persist($category);
    }
}
