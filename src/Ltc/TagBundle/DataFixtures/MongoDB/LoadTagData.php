<?php

namespace Ltc\ArticleBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

use Ltc\TagBundle\Document\Tag;

class LoadTagData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    const TAG_TABLE         = 'pap_tag';

    protected $tags;
    protected $tagRepository;

    public function getOrder()
    {
        return 6;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->tags = $container->get('ltc_import.unserializer')->unserialize(self::TAG_TABLE);
        $this->tagRepository = $container->get('ltc_tag.repository.tag');
    }

    public function load($manager)
    {
        foreach ($this->tags as $a) {
            $o = $this->tagRepository->create($a['nom'], $a['strip']);
            $manager->persist($o);
        }
        $manager->flush();
    }
}
