<?php

namespace CryptYO\HomeBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CryptYOHomeBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
