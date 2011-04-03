<?php

namespace Ltc\TagBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

use Ltc\TagBundle\Document\Tag;

class LoadTagDocCountData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    protected $tagDenormalizer;

    public function getOrder()
    {
        return 20;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->tagDenormalizer = $container->get('ltc_tag.denormalizer');
    }

    public function load($manager)
    {
        $this->tagDenormalizer->denormalize();

        $manager->flush();
    }
}
