<?php

namespace Ltc\DocBundle\Document;

use Doctrine\ODM\MongoDB\DocumentRepository;
use MongoId;

abstract class DocRepository extends DocumentRepository
{
    /**
     * Gets the featured doc
     *
     * @return Doc
     **/
    public function findOneFeatured()
    {
        return $this->createPublishedQueryBuilder()
            ->limit(1)
            ->getQuery()
            ->getSingleResult();
    }

    /**
     * Find all docs sorted by creation date desc
     * Also returns non-published docs
     *
     * @return array
     **/
    public function findAll()
    {
        return $this->createQueryBuilder()
            ->sort('createdAt', 'desc')
            ->getQuery()
            ->execute();
    }

    /**
     * Find related documents based on tag matching
     *
     * @return array
     **/
    public function findRelated(Doc $doc, $limit = 10)
    {
        $tagSlugs = $doc->getTagSlugs();
        $related = $this->createPublishedQueryBuilder()
            ->field('tags.$id')->in($tagSlugs)
            ->field('_id')->notEqual($doc->getId())
            ->getQuery()
            ->execute()
            ->toArray();

        $correlationClosure = function(array $tagSlugs, $doc)
        {
            return count(array_intersect($tagSlugs, $doc->getTagSlugs()));
        };
        $sortCallback = function($a, $b) use ($tagSlugs, $correlationClosure)
        {
            return $correlationClosure($tagSlugs, $a) < $correlationClosure($tagSlugs, $b);
        };
        usort($related, $sortCallback);

        return array_slice($related, 0, $limit);
    }

    /**
     * Find published documents
     *
     * @return void
     */
    public function findPublished()
    {
        return $this->createPublishedQueryBuilder()
            ->getQuery()
            ->execute();
    }

    /**
     * Find the more recently published docs
     *
     * @return array
     **/
    public function findLatest($number)
    {
        return $this->createPublishedQueryBuilder()
            ->limit($number)
            ->getQuery()
            ->execute();
    }

    /**
     * Creates a query builder for published docs
     *
     * @return null
     **/
    public function createPublishedQueryBuilder()
    {
        return $this->createQueryBuilder()
            ->field('isPublished')->equals(true)
            ->sort('publishedAt', 'desc');
    }
}
