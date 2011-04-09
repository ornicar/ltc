<?php

namespace Ltc\ConfigBundle;

use Symfony\Component\Form\FormContextInterface;

class FormFactory
{
    protected $context;
    protected $name;
    protected $class;

    public function __construct(FormContextInterface $context, $name, $class)
    {
        $this->context = $context;
        $this->name    = $name;
        $this->class   = $class;
    }

    public function create(array $options = array())
    {
        $form = call_user_func_array(array($this->class, 'create'), array($this->context, $this->name, $options));

        return $form;
    }
}
