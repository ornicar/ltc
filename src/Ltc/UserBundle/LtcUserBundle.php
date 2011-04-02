<?php

namespace Ltc\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class LtcUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUser';
    }
}
