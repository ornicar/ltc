<?php

namespace Ltc\ArticleBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class LtcArticleBundle extends Bundle
{
    public function getParent()
    {
        return 'LtcDoc';
    }
}
