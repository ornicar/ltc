<?php

namespace Ltc\TagBundle\Form\ValueTransformer;

use Symfony\Component\Form\ValueTransformer\ValueTransformerInterface;
use Symfony\Component\Form\Configurable;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Ltc\TagBundle\Document\TagRepository;

/**
 * Transforms between a doctrine object and an id
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
class TagsValueTransformer extends Configurable implements ValueTransformerInterface
{
    /**
     * Object repository
     *
     * @var TagRepository
     */
    protected $repository = null;

    public function __construct(TagRepository $repository)
    {
        $this->repository = $repository;
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

        return implode(', ', array_map(function($tag) { return $tag->getTitle(); }, $value));
    }

    /**
     * reverseTransform
     *
     * @param string $value
     * @return array of tag objects
     */
    public function reverseTransform($value)
    {
        $titles = array_filter(array_map('trim', explode(',', $value)));
        $tags = $this->repository->findByTitlesOrCreate($titles)->toArray();

        return new ArrayCollection($tags);
    }
}
