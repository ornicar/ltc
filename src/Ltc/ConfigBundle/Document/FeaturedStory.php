<?php

namespace Ltc\ConfigBundle\Document;

use Ltc\StoryBundle\Document\Story;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class FeaturedStory
{
    /**
     * Unique ID
     *
     * @var string
     * @MongoDB\Id()
     */
    protected $id;

    /**
     * Story
     *
     * @var Story
     * @MongoDB\ReferenceOne(targetDocument="Ltc\StoryBundle\Document\Story")
     */
    protected $story;

    /**
     * @return Story
     */
    public function getStory()
    {
        return $this->story;
    }

    /**
     * @param  Story
     * @return null
     */
    public function setStory(Story $story)
    {
        $this->story = $story;
    }
}
