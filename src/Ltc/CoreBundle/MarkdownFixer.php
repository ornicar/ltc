<?php

namespace Ltc\CoreBundle;

use Closure;

class MarkdownFixer
{
    public function fix($text)
    {
        $text = $this->trimLines($text);
        $text = $this->fixDotList($text);
        $text = $this->fixDotLine($text);
        $text = $this->makeRealParagraphs($text);

        return $text;
    }

    protected function makeRealParagraphs($text)
    {
        return preg_replace('/(\.|\;|\:|\?|\!)\n(\w)/is', "\$1\n\n\$2", $text);
    }

    protected function trimLines($text)
    {
        return $this->eachLine($text, function($line) {
            return rtrim($line);
        });
    }

    protected function normalizeLists($text)
    {
        return $this->eachLine($text, function($line) {
            return preg_replace('/^\*/', '-', $line);
        });
    }

    protected function fixDotList($text)
    {
        return $this->eachLine($text, function($line) {
            return preg_replace('/^\s*\./', '-', $line);
        });
    }

    protected function fixDotLine($text)
    {
        return $this->eachLine($text, function($line) {
            return preg_replace('/^.$/', '', $line);
        });
    }

    protected function eachLine($text, Closure $callback)
    {
        $lines = explode("\n", $text);

        $lines = array_map($callback, $lines);

        return implode("\n", $lines);
    }
}
