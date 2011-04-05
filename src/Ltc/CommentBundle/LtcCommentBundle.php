<?php

namespace Ltc\CommentBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class LtcCommentBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSComment';
    }
}
