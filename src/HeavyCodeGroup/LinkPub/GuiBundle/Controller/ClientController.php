<?php

namespace HeavyCodeGroup\LinkPub\GuiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ClientController extends Controller
{
    public function sitesAction()
    {
        return $this->render('@LinkPubGui/Client/sites.html.twig');
    }
}
