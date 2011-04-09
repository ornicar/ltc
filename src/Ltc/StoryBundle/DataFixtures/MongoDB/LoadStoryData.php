<?php

namespace Ltc\StoryBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

use Ltc\StoryBundle\Document\Story;
use DateTime;

class LoadStoryData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    const ACTU_TABLE         = 'pap_actu';

    protected $actus;
    protected $storyRepository;

    public function getOrder()
    {
        return 6;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->actus = $container->get('ltc_import.unserializer')->unserialize(self::ACTU_TABLE);
        $this->storyRepository = $container->get('ltc_story.repository.story');
    }

    public function load($manager)
    {
        foreach ($this->actus as $a) {
            $o = new Story();
            $o->setTitle($a['nom']);
            $body = $a['description'];
            if ($a['url']) {
                $body .= sprintf(' [%s](%s)', 'Lire la suite...', $a['url']);
            }
            $o->setBody($body);
            if ($a['auteur']) {
                $o->setAuthorName($a['auteur']);
            }
            $o->setIsPublished(true);
            $o->setPublishedAt(new DateTime($a['created_at']));
            $o->setCreatedAt(new DateTime($a['created_at']));
            $o->setUpdatedAt(new DateTime($a['updated_at']));
            $manager->persist($o);
        }

        $manager->flush();
    }
}
