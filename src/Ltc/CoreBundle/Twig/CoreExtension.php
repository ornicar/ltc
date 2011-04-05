<?php

namespace Ltc\CoreBundle\Twig;

use Twig_Extension;
use Twig_Filter_Method;
use DateTime;

class CoreExtension extends \Twig_Extension
{
    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return array An array of filters
     */
    public function getFilters()
    {
        return array(
            'ltc_date' => new Twig_Filter_Method($this, 'formatDate'),
            'ltc_shrink_link' => new Twig_Filter_Method($this, 'shrinkLink')
        );
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

    /**
     * (non-PHPdoc)
     * @see Twig_ExtensionInterface::getName()
     */
    public function getName()
    {
        return 'ltc_core';
    }
}
