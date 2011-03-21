<?php

namespace Ltc\TagBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

class TagAdmin extends Admin
{
    protected $list = array(
        'title' => array('identifier' => true),
        'slug',
    );

    protected $form = array(
        'title',
    );

    protected $filter = array(
        'title',
    );
}
