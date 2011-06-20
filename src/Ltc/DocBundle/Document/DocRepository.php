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
        return $this->createPublishedSortedQueryBuilder()
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
        return $this->createPublishedSortedQueryBuilder()
            ->field('tags.$id')->in($doc->getTagSlugs())
            ->field('_id')->notEqual($doc->getId())
            ->getQuery()
            ->execute()
            ->toArray();
    }

    /**
     * Find published documents
     *
     * @return array
     */
    public function findPublished($limit = null)
    {
        $queryBuilder = $this->createPublishedSortedQueryBuilder();

        if ($limit) {
            $queryBuilder->limit($limit);
        }

        return $queryBuilder
            ->getQuery()
            ->execute();
    }

    /**
     * Finds published documents
     * and only loads the titles and slugs
     *
     * @return array of partially hydrated document proxies
     */
    public function findPublishedTitleAndSlug()
    {
        return $this->createPublishedSortedQueryBuilder()
            ->select('title', 'slug')
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
        return $this->createPublishedSortedQueryBuilder()
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
            ->field('isPublished')->equals(true);
    }

    /**
     * Creates a query builder for published docs
     *
     * @return null
     **/
    public function createPublishedSortedQueryBuilder()
    {
        return $this->createPublishedQueryBuilder()
            ->sort('publishedAt', 'desc');
    }

    /**
     * Finds one article from a slug
     * The slug property ain't necessarily unique!
     *
     * @return Article
     **/
    public function findOnePublishedBySlug($slug)
    {
        return $this->createPublishedQueryBuilder()
            ->field('slug')->equals($slug)
            ->getQuery()
            ->getSingleResult();
    }

    /**
     * Finds published documents with the given ids
     *
     * @return array
     **/
    public function findPublishedByIds(array $ids)
    {
        return $this->createPublishedQueryBuilder()
            ->field('id')->in($ids)
            ->getQuery()
            ->execute();
    }
}
