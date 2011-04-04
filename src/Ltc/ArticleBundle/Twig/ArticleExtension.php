<?php

namespace Ltc\ArticleBundle\Twig;

use Ltc\ArticleBundle\Provider;
use Twig_Extension;
use Twig_Function_Method;

class ArticleExtension extends \Twig_Extension
{
    /**
     * @var Provider
     */
    private $cachePathResolver;

    /**
     * Constructs by setting $provider
     *
     * @param Provider $provider
     */
    public function __construct(Provider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Returns a list of global functions to add to the existing list.
     *
     * @return array An array of global functions
     */
    public function getFunctions()
    {
        $mappings = array(
            'ltc_article_categories_infos' => 'getCategoriesInfos',
        );

        $functions = array();
        foreach($mappings as $twigFunction => $method) {
            $functions[$twigFunction] = new Twig_Function_Method($this, $method, array('is_safe' => array('html')));
        }

        return $functions;
    }

    /**
     * Proxy to Provider::getCategoriesInfos
     *
     * @return array
     */
    public function getCategoriesInfos()
    {
        return $this->provider->getCategoriesInfos();
    }

    /**
     * (non-PHPdoc)
     * @see Twig_ExtensionInterface::getName()
     */
    public function getName()
    {
        return 'ltc_article';
    }
}
