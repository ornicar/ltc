<?php

namespace Ltc\TagBundle\Twig;

use Twig_Extension;
use Twig_Function_Method;

class TagExtension extends \Twig_Extension
{
    protected $average = 10;

    /**
     * Returns a list of global functions to add to the existing list.
     *
     * @return array An array of global functions
     */
    public function getFunctions()
    {
        $mappings = array(
            'ltc_tag_cloud_style' => 'getTagCloudStyle',
            'ltc_tag_cloud_init' => 'init',
        );

        $functions = array();
        foreach($mappings as $twigFunction => $method) {
            $functions[$twigFunction] = new Twig_Function_Method($this, $method, array('is_safe' => array('html')));
        }

        return $functions;
    }

    /**
     * Initializes the averag tag doc count
     *
     * @return null
     **/
    public function init(array $tags)
    {
        $this->average = 0;
        foreach ($tags as $tag) {
            $this->average += $tag->getDocCount();
        }
        $this->average /= count($tags);
    }

    /**
     * Get style attributes for the tag link depending on its popularity
     *
     * @return string
     */
    public function getTagCloudStyle($docCount)
    {
        $fontSize = $docCount / $this->average;
        $fontSize = max(0.6, min(1.5, $fontSize));

        return sprintf('font-size: %sem;', round($fontSize, 1));
    }

    /**
     * (non-PHPdoc)
     * @see Twig_ExtensionInterface::getName()
     */
    public function getName()
    {
        return 'ltc_tag';
    }
}
