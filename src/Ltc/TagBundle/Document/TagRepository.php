<?php

namespace Ltc\TagBundle\Document;

use Doctrine\ODM\MongoDB\DocumentRepository;
use MongoId;
use Gedmo\Sluggable\Util\Urlizer;


class TagRepository extends DocumentRepository
{
    /**
     * Find all tags ordered by slug asc
     *
     * @return array
     **/
    public function findAll()
    {
        return $this->createQueryBuilder()
            ->sort('_id', 'asc')
            ->getQuery()
            ->execute();
    }

    /**
     * Return all tags indexed by their slug
     *
     * @return array
     **/
    public function findAllIndexBySlug()
    {
        $indexed = array();
        foreach ($this->findAll()->toArray() as $tag) {
            $indexed[$tag->getSlug()] = $tag;
        }

        return $indexed;
    }

    /**
     * Finds tags for the given titles
     *
     * @return array
     **/
    public function findByTitlesOrCreate(array $titles)
    {
        $tags = $this->createQueryBuilder()
            ->field('title')->in($titles)
            ->getQuery()
            ->execute();

        foreach ($titles as $title) {
            foreach ($tags as $tag) {
                if ($title === $tag->getTitle()) {
                    continue 2;
                }
            }

            $tag = $this->create($title);
            $this->dm->persist($tag);
        }

        return $tags;
    }

    /**
     * Create a new tag
     *
     * @return Tag
     **/
    public function create($title, $slug = null)
    {
        if (null === $slug) {
            $slug = Urlizer::urlize($title);
        }

        return new Tag($title, $slug);
    }
}
