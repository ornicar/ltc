<?php

namespace Ltc\TagBundle\Document;

use Doctrine\ODM\MongoDB\DocumentRepository;
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
            ->sort('slug', 'asc')
            ->getQuery()
            ->execute();
    }

    /**
     * Gets the list of tag titles
     *
     * @return array of strings
     */
    public function findAllTitles()
    {
        $tags = $this->createQueryBuilder()
            ->select('title')
            ->hydrate(false)
            ->getQuery()
            ->execute()
            ->toArray();

        return array_map(function(array $tag) { return $tag['title']; }, array_values($tags));
    }

    /**
     * Finds the more popular slugs and returns them ordered by slug
     *
     * @return array
     **/
    public function findMorePopularSortBySlug($limit)
    {
        $tags = $this->createQueryBuilder()
            ->sort('docCount', 'desc')
            ->limit($limit)
            ->getQuery()
            ->execute()
            ->toArray();

        usort($tags, function($a, $b) {
            return $a->getSlug() > $b->getSlug();
        });

        return $tags;
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
