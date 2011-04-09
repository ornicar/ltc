<?php

namespace Ltc\ConfigBundle\Document;

use Ltc\StoryBundle\Document\Story;

/**
 * @mongodb:Document
 */
class FeaturedStory
{
    /**
     * Unique ID
     *
     * @var string
     * @mongodb:Id()
     */
    protected $id;

    /**
     * Story
     *
     * @var Story
     * @mongodb:ReferenceOne(targetDocument="Ltc\StoryBundle\Document\Story")
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
