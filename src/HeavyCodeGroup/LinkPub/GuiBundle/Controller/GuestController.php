<?php

namespace HeavyCodeGroup\LinkPub\GuiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GuestController extends Controller
{
   public function indexAction()
   {

       return $this->render('LinkPubGuiBundle:Guest:index.html.twig');
   }
}
