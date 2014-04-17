<?php

namespace HeavyCodeGroup\LinkPub\GuiBundle\Controller;

use HeavyCodeGroup\LinkPub\BaseBundle\Controller\BaseController;

class GuestController extends BaseController
{
   public function indexAction()
   {

       return $this->render('LinkPubGuiBundle:Guest:index.html.twig');
   }
}
