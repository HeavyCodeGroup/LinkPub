<?php

namespace HeavyCodeGroup\LinkPub\GuiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GuestController extends Controller
{
   public function indexAction()
   {
       $about = $this->getDoctrine()
           ->getRepository('LinkPubGuiBundle:About')
           ->findAll();

       return $this->render('LinkPubGuiBundle:Guest:index.html.twig', array( 'about' => $about));
   }
}
