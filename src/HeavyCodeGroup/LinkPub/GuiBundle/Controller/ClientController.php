<?php

namespace HeavyCodeGroup\LinkPub\GuiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ClientController extends Controller
{
    public function dashboardAction()
    {
        return $this->render('@LinkPubGui/Client/dashboard.html.twig');
    }

    public function sitesAction()
    {
        return $this->render('@LinkPubGui/Client/sites.html.twig');
    }

    public function incomingLinksAction()
    {
        return $this->render('@LinkPubGui/Client/incomingLinks.html.twig');
    }

    public function outgoingLinksAction()
    {
        return $this->render('@LinkPubGui/Client/outgoingLinks.html.twig');
    }
}
