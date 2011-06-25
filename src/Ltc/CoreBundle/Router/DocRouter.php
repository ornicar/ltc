<?php

namespace Ltc\CoreBundle\Router;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Ltc\BlogBundle\Document\BlogEntry;
use Ltc\ArticleBundle\Document\Article;
use Ltc\DocBundle\Document\Doc;

class DocRouter
{
    protected $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
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
}
