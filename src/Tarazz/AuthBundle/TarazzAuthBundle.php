<?php

namespace Tarazz\AuthBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class TarazzAuthBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
