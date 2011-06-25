<?php

namespace Ltc\CoreBundle\Twig;

use Twig_Extension;
use Twig_Function_Method;
use Ltc\DocBundle\Document\Doc;
use Ltc\CoreBundle\Router\DocRouter;

class RouterExtension extends Twig_Extension
{
    protected $router;

    public function __construct(DocRouter $router)
    {
        $this->router = $router;
    }

    /**
     * Returns a list of global functions to add to the existing list.
     *
     * @return array An array of global functions
     */
    public function getFunctions()
    {
        $mappings = array(
            'ltc_doc_url'  => 'getDocUrl',
            'ltc_doc_path' => 'getDocPath'
        );

        $functions = array();
        foreach($mappings as $twigFunction => $method) {
            $functions[$twigFunction] = new Twig_Function_Method($this, $method, array('is_safe' => array('html')));
        }

        return $functions;
    }

    /**
     * Gets the path for a blog entry or an article
     *
     * @return string
     **/
    public function getDocPath(Doc $doc)
    {
        return $this->router->getDocPath($doc);
    }

    /**
     * Gets the url for a blog entry or an article
     *
     * @return string
     **/
    public function getDocUrl(Doc $doc)
    {
        return $this->router->getDocUrl($doc);
    }

    /**
     * (non-PHPdoc)
     * @see Twig_ExtensionInterface::getName()
     */
    public function getName()
    {
        return 'ltc_router';
    }
}

