<?php

namespace Ltc\CoreBundle\Form\ValueTransformer;

use Symfony\Component\Form\ValueTransformer\ValueTransformerInterface;
use Symfony\Component\Form\Configurable;
use Doctrine\Common\Collections\Collection;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Iterator, IteratorAggregate;

/**
 * Transforms between a doctrine object and an id
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
class DoctrineObjectTransformer extends Configurable implements ValueTransformerInterface
{
    /**
     * Object repository
     *
     * @var DocumentRepository
     */
    protected $repository = null;

    public function __construct(DocumentRepository $repository)
    {
        if(!method_exists($repository, 'find')) {
            throw new \InvalidArgumentException('The repository must implement a find method');
        }
        $this->repository = $repository;
    }

    /**
     * Transforms an object into an id
     *
     * @param  mixed $value     Object
     * @return string           String id
     */
    public function transform($value)
    {
        if(null === $value) {
            return null;
        }
        if(is_array($value) || $value instanceof Iterator || $value instanceof IteratorAggregate) {
            $transformed = array();
            foreach($value as $index => $v) {
                $transformed[$index] = $this->transform($v);
            }

            return $transformed;
        }
        if (!is_object($value)) {
            throw new \InvalidArgumentException(sprintf('Expected argument of type object but got %s.', gettype($value)));
        }

        if(!method_exists($value, 'getId')) {
            throw new \InvalidArgumentException('The object must implement a getId method');
        }

        return $value->getId();
    }

    public function reverseTransform($value)
    {
        if(is_array($value) || $value instanceof Iterator || $value instanceof IteratorAggregate) {
            $transformed = array();
            foreach($value as $index => $v) {
                $transformed[$index] = $this->reverseTransform($v);
            }

            return $transformed;
        }

        return $this->repository->find($value);
    }
}
