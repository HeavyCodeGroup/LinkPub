<?php

namespace HeavyCodeGroup\LinkPub\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use HeavyCodeGroup\LinkPub\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function homepageAction()
    {
        return $this->render('@LinkPubUser/User/homepage.html.twig');
    }

}