<?php

namespace HeavyCodeGroup\LinkPub\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function homepageAction()
    {
        return $this->render('@LinkPubUser/User/homepage.html.twig');
    }
}