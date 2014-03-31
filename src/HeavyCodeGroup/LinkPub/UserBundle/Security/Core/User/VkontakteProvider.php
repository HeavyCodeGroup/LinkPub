<?php

namespace HeavyCodeGroup\LinkPub\UserBundle\Security\Core\User;

use HeavyCodeGroup\LinkPub\UserBundle\Entity\User;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;

class VkontakteProvider
{
    public function setUserData(User $user, UserResponseInterface $response)
    {
        $responseArray = $response->getResponse();
        $username = $response->getUsername();

        $user->setFirstNameVkontakte($responseArray['response'][0]['first_name']);
        $user->setLastNameVkontakte($responseArray['response'][0]['last_name']);
        $user->setEmail('id'.$user->GetVkontakteId().'@vk.com');
        $user->setUsername($username .'Vkontakte');
        $user->setPassword($username);
        $user->setVkontakteId($response->getUsername());
        $user->setVkontakteAccessToken($response->getAccessToken());
        $user->setEnabled(true);

        return $user;
    }

    public function setAddUserData(User $user, UserResponseInterface $response)
    {
        $responseArray = $response->getResponse();
        $user->setFirstNameVkontakte($responseArray['response'][0]['first_name']);
        $user->setLastNameVkontakte($responseArray['response'][0]['last_name']);
        $user->setFacebookId($response->getUsername());
        $user->setFacebookAccessToken($response->getAccessToken());
        return $user;
    }
}