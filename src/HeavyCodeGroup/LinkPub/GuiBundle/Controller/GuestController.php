<?php

namespace HeavyCodeGroup\LinkPub\GuiBundle\Controller;

use HeavyCodeGroup\LinkPub\BaseBundle\Controller\BaseController;

class GuestController extends BaseController
{
   public function indexAction()
   {
       $about = $this->getDoctrine()
           ->getRepository('LinkPubGuiBundle:About')
           ->findAll();

       return $this->render('LinkPubGuiBundle:Guest:index.html.twig', array( 'about' => $about));
   }
}
