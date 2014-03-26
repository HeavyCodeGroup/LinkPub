<?php

namespace HeavyCodeGroup\LinkPub\UserBundle\Security\Core\User;

use HeavyCodeGroup\LinkPub\UserBundle\Entity\User;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;

class FacebookProvider
{
    public function setUserData(User $user, UserResponseInterface $response)
    {
        $responseArray = $response->getResponse();
        //$user->setUsername($username);
        $user->setFirstNameFacebook($responseArray['first_name']);
        $user->setLastNameFacebook($responseArray['last_name']);
        $user->setEmail($responseArray['email']);

        return $user;
    }
}