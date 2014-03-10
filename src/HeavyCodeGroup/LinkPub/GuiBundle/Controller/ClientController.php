<?php

namespace HeavyCodeGroup\LinkPub\GuiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ClientController extends Controller
{
    public function dashboardAction()
    {
        return $this->render('LinkPubGuiBundle:Client:dashboard.html.twig');
    }

    public function sitesAction()
    {
        return $this->render('LinkPubGuiBundle:Client:sites.html.twig');
    }

    public function incomingLinksAction()
    {
        return $this->render('LinkPubGuiBundle:Client:incomingLinks.html.twig');
    }

    public function outgoingLinksAction()
    {
        return $this->render('LinkPubGuiBundle:Client:outgoingLinks.html.twig');
    }
}
