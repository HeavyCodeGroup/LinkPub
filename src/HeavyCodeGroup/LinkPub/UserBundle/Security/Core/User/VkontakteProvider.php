<?php

namespace HeavyCodeGroup\LinkPub\UserBundle\Security\Core\User;

use HeavyCodeGroup\LinkPub\UserBundle\Entity\User;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;

class VkontakteProvider
{
    public function setUserData(User $user, UserResponseInterface $response)
    {
        $responseArray = $response->getResponse();

        $user->setFirstNameVkontakte($responseArray['response'][0]['first_name']);
        $user->setLastNameVkontakte($responseArray['response'][0]['last_name']);
        $user->setEmail('id'.$user->GetVkontakteId().'@vk.com');

        return $user;
    }

    public function setAddUserData(User $user, UserResponseInterface $response)
    {
        $responseArray = $response->getResponse();
        $user->setFirstNameVkontakte($responseArray['response'][0]['first_name']);
        $user->setLastNameVkontakte($responseArray['response'][0]['last_name']);
        return $user;
    }
}