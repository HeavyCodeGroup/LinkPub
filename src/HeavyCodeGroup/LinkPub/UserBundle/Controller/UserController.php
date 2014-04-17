<?php

namespace HeavyCodeGroup\LinkPub\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use HeavyCodeGroup\LinkPub\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function signInAction()
    {
        return $this->render('@LinkPubUser/User/signIn.html.twig');
    }

}