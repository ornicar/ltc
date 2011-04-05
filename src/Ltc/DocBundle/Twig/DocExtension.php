<?php

namespace Ltc\DocBundle\Twig;

use Twig_Extension;
use Twig_Function_Method;
use Ltc\DocBundle\Document\Doc;
use Ltc\CoreBundle\Twig\CoreExtension;
use Ltc\ArticleBundle\Document\Article;
use Ltc\BlogBundle\Document\BlogEntry;

class DocExtension extends \Twig_Extension
{
    protected $coreExtension;

    /**
     * Constructor
     *
     * @return null
     **/
    public function __construct(CoreExtension $coreExtension)
    {
        $this->coreExtension = $coreExtension;
    }

    /**
     * Returns a list of global functions to add to the existing list.
     *
     * @return array An array of global functions
     */
    public function getFunctions()
    {
        $mappings = array(
            'ltc_doc_author'                      => 'getAuthor',
            'ltc_doc_publication_date'            => 'getPublicationDate',
            'ltc_doc_publication_date_and_author' => 'getPublicationDateAndAuthor',
            'ltc_doc_controller'                  => 'getController'
        );

        $functions = array();
        foreach($mappings as $twigFunction => $method) {
            $functions[$twigFunction] = new Twig_Function_Method($this, $method, array('is_safe' => array('html')));
        }

        return $functions;
    }

    /**
     * Get the best controller for this doc
     *
     * @return string
     **/
    public function getController(Doc $doc)
    {
        if ($doc instanceof Article) {
            return 'LtcArticle:Article';
        } elseif ($doc instanceof BlogEntry) {
            return 'LtcBlog:Entry';
        }
    }

    /**
     * Get the doc author name and bio
     *
     * @return string
     */
    public function getAuthor(Doc $doc, $default = 'Pascal Duplessis')
    {
        if ($doc->hasAuthor()) {
            $author = $doc->getAuthorName();
            if ($bio = $doc->getAuthorBio()) {
                $author .= ', '.$bio;
            }
        } else {
            $author = $default;
        }

        return $author;
    }

    /**
     * Get the doc publication date
     *
     * @return string
     */
    public function getPublicationDate(Doc $doc)
    {
        if ($doc->hasPublicationDate()) {
            $date = $doc->getPublicationDate();
        } else {
            $date = $this->coreExtension->formatDate($doc->getPublishedAt());
        }

        return $date;
    }

    public function getPublicationDateAndAuthor(Doc $doc, $separator = ', ')
    {
        $string = $this->getPublicationDate($doc);
        $author = $author = $this->getAuthor($doc);
        if (!empty($author)) {
            $string .= sprintf('%spar %s', $separator, $author);
        }

        return $string;
    }

    /**
     * (non-PHPdoc)
     * @see Twig_ExtensionInterface::getName()
     */
    public function getName()
    {
        return 'ltc_doc';
    }
}
