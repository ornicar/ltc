<?php

namespace Ltc\MarkdownBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class LtcMarkdownBundle extends Bundle
{
    public function getParent()
    {
        return 'KnplabsMarkdown';
    }
}
