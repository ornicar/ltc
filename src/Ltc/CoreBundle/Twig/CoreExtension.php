<?php

namespace Ltc\CoreBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Twig_Extension;
use Twig_Filter_Method;
use Twig_Function_Method;
use DateTime;
use Ltc\DocBundle\Document\Doc;
use Ltc\ArticleBundle\Document\Article;
use Ltc\BlogBundle\Document\BlogEntry;

class CoreExtension extends Twig_Extension
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Returns a list of global functions to add to the existing list.
     *
     * @return array An array of global functions
     */
    public function getFunctions()
    {
        $mappings = array(
            'ltc_js_config' => 'getJsConfig',
            'ltc_doc_category_title' => 'getDocCategoryTitle'
        );

        $functions = array();
        foreach($mappings as $twigFunction => $method) {
            $functions[$twigFunction] = new Twig_Function_Method($this, $method, array('is_safe' => array('html')));
        }

        return $functions;
    }

    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return array An array of filters
     */
    public function getFilters()
    {
        return array(
            'ltc_date' => new Twig_Filter_Method($this, 'formatDate'),
            'ltc_shrink_link' => new Twig_Filter_Method($this, 'shrinkLink'),
            'ltc_comment' => new Twig_Filter_Method($this, 'formatComment')
        );
    }

    /**
     * Gets the category title of articles, or the name of the blog
     *
     * @return string
     **/
    public function getDocCategoryTitle(Doc $doc)
    {
        if ($doc instanceof BlogEntry) {
            return "Table ronde";
        } elseif ($doc instanceof Article) {
            return $doc->getCategory()->getTitle();
        } else {
            throw new \InvalidArgumentException(get_class($doc));
        }
    }

    /**
     * Tries to format a date in french
     *
     * @return string
     **/
    public function formatDate(DateTime $date)
    {
        $months = array('', 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');

        return sprintf('%d %s %d',
            $date->format('d'),
            $months[$date->format('n')],
            $date->format('Y')
        );
    }

    /**
     * Replace urls with <a href="url">$name</a>
     *
     * @return null
     **/
    public function shrinkLink($text, $name = 'lien')
    {
        return preg_replace(
            "#((http|https|ftp)://(\S*?\.\S*?))(\s|\;|\)|\]|\[|\{|\}|,|\"|'|:|\<|$|\.\s)#ie",
            "'<a href=\"$1\">".$name."</a>$4'",
            $text
        );
    }

    protected function autoLink($text)
    {
        return preg_replace_callback('~
            (                       # leading text
                <\w+.*?>|             #   leading HTML tag, or
                [^=!:\'"/]|           #   leading punctuation, or
                ^                     #   beginning of line
            )
            (
                (?:https?://)|        # protocol spec, or
                (?:www\.)             # www.*
            )
            (
                [-\w]+                   # subdomain or domain
                (?:\.[-\w]+)*            # remaining subdomains or domain
                (?::\d+)?                # port
                (?:/(?:(?:[\~\w\+%-\@]|(?:[,.;:][^\s$]))+)?)* # path
                (?:\?[\w\+%&=.;-]+)?     # query string
                (?:\#[\w\-]*)?           # trailing anchor
            )
            ([[:punct:]]|\s|<|$)    # trailing text
            ~x',
            function($matches)
            {
                if (preg_match("/<a\s/i", $matches[1]))
                {
                    return $matches[0];
                }
                else
                {
                    return $matches[1].'<a href="'.($matches[2] == 'www.' ? 'http://www.' : $matches[2]).$matches[3].'" target="_blank">'.$matches[2].$matches[3].'</a>'.$matches[4];
                }
            },
            $text
        );
    }

    public function formatComment($text)
    {
        return nl2br($this->autoLink($this->escape($text)));
    }

    public function shorten($text, $length = 140)
    {
        return mb_substr(str_replace("\n", ' ', $this->escape($text)), 0, $length);
    }

    public function escape($string)
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }

    public function getJsConfig()
    {
        return array(
            'base_url' => $this->container->get('request')->getBasePath()
        );
    }

    /**
     * (non-PHPdoc)
     * @see Twig_ExtensionInterface::getName()
     */
    public function getName()
    {
        return 'ltc_core';
    }
}
