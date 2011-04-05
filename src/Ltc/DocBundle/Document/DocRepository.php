<?php

namespace Ltc\DocBundle\Document;

use Ltc\TagBundle\Document\Tag;
use Doctrine\ODM\MongoDB\DocumentRepository;
use MongoId;

abstract class DocRepository extends DocumentRepository
{
    /**
     * Find all published docs having this tag
     *
     * @return array
     **/
    public function findPublishedByTag(Tag $tag)
    {
        return $this->createPublishedQueryBuilder()
            ->field('tags.$id')->equals($tag->getSlug())
            ->getQuery()
            ->execute();
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
    public function findPublishedRelated(Doc $doc)
    {
        return $this->createPublishedQueryBuilder()
            ->field('tags.$id')->in($doc->getTagSlugs())
            ->field('_id')->notEqual($doc->getId())
            ->getQuery()
            ->execute()
            ->toArray();
    }

    /**
     * Find published documents
     *
     * @return void
     */
    public function findPublished($limit = null)
    {
        $queryBuilder = $this->createPublishedQueryBuilder();

        if ($limit) {
            $queryBuilder->limit($limit);
        }

        return $queryBuilder
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
