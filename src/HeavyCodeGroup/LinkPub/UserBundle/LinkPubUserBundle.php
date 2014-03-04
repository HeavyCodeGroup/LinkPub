<?php

namespace HeavyCodeGroup\LinkPub\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class LinkPubUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
