<?php

namespace Ltc\TagBundle\Form\DataTransformer;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Ltc\TagBundle\Document\TagRepository;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * Transforms between a doctrine object and an id
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
class TagsDataTransformer implements DataTransformerInterface
{
    /**
     * @var TagRepository
     */
    protected $repository;

    protected $separator;

    public function __construct(TagRepository $repository, $separator = ', ')
    {
        $this->repository = $repository;
        $this->separator = $separator;
    }

    /**
     * Transforms a tag collection to a comma separated list of slugs
     *
     * @param  Collection $value     Tags collection
     * @return string           slugs
     */
    public function transform($value)
    {
        if (null === $value) {
            return null;
        }
        if (!is_array($value)) {
            $value = $value->toArray();
        }

        return implode($this->separator, array_map(function($tag) { return $tag->getTitle(); }, $value));
    }

    /**
     * reverseTransform
     *
     * @param string $value
     * @return array of tag objects
     */
    public function reverseTransform($value)
    {
        $titles = array_filter(array_map('trim', explode(trim($this->separator), $value)));
        $tags = $this->repository->findByTitlesOrCreate($titles);

        return new ArrayCollection($tags);
    }
}
