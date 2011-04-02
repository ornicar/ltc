<?php

namespace Ltc\DocBundle\Document;

use Doctrine\ODM\MongoDB\DocumentRepository;
use MongoId;

abstract class DocRepository extends DocumentRepository
{
    /**
     * Find related documents based on tag matching
     *
     * @return array
     **/
    public function findRelated(Doc $doc, $limit = 10)
    {
        $tagSlugs = $doc->getTagSlugs();
        $related = $this->createQueryBuilder()
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
}
