<?php

namespace HeavyCodeGroup\LinkPub\DispenserBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class FakeRouterListener
{
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        $request->attributes->add(array(
            '_controller' => 'link_pub_dispenser.controller.default:indexAction'
        ));
    }
}
