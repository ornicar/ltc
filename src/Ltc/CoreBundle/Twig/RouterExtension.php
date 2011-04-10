<?php

namespace Ltc\CoreBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Twig_Extension;
use Twig_Function_Method;
use Ltc\DocBundle\Document\Doc;
use Ltc\ArticleBundle\Document\Article;
use Ltc\BlogBundle\Document\BlogEntry;

class RouterExtension extends Twig_Extension
{
    protected $urlGenerator;

    public function __construct(ContainerInterface $container)
    {
        $this->urlGenerator = $container->get('router')->getGenerator();
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
        return $this->generateForDoc($doc, false);
    }

    /**
     * Gets the url for a blog entry or an article
     *
     * @return string
     **/
    public function getDocUrl(Doc $doc)
    {
        return $this->generateForDoc($doc, true);
    }

    protected function generateForDoc(Doc $doc, $absolute)
    {
        $params = array('slug' => $doc->getSlug());
        if ($doc instanceof BlogEntry) {
            $route = 'ltc_blog_entry_view';
        } elseif ($doc instanceof Article) {
            $route = 'ltc_article_article_view';
            $params['categorySlug'] = $doc->getCategory()->getSlug();
        } else {
            throw new \InvalidArgumentException(get_class($doc));
        }

        return $this->urlGenerator->generate($route, $params, $absolute);
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

