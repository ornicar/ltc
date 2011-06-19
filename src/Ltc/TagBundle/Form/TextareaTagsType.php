<?php

namespace Ltc\TagBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Ltc\TagBundle\Form\DataTransformer\TagsDataTransformer;
use Ltc\TagBundle\Document\TagRepository;

/**
 * Text representing a list of tags
 */
class TextareaTagsType extends AbstractType
{
    /**
     * @var TagRepository
     */
    protected $repository;

    public function __construct(TagRepository $repository)
    {
        $this->repository = $repository;
    }

    public function buildForm(FormBuilder $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $transformer = new TagsDataTransformer($this->repository, $options['list_separator']);
        $builder->appendClientTransformer($transformer);
    }

    public function getParent(array $options)
    {
        return 'textarea';
    }

    public function getName()
    {
        return 'ltc_tags';
    }

    public function getDefaultOptions(array $options)
    {
        $options = parent::getDefaultOptions($options);

        $options['list_separator'] = ',';

        return $options;
    }
}
