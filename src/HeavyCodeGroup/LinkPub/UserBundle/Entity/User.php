<?php

namespace  HeavyCodeGroup\LinkPub\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */

class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** @ORM\Column(name="facebook_id", type="string", length=255, nullable=true) */
    protected $facebook_id;

    /** @ORM\Column(name="facebook_access_token", type="string", length=255, nullable=true) */
    protected $facebook_access_token;

    /** @ORM\Column(name="vkontakte_id", type="string", length=255, nullable=true) */
    protected $vkontakte_id;

    /** @ORM\Column(name="vkontakte_access_token", type="string", length=255, nullable=true) */
    protected $vkontakte_access_token;

    public function __construct()
    {
        parent::__construct();

    }

    /**
     * @return mixed
     */
    public function getVkontakteAccessToken()
    {
        return $this->vkontakte_access_token;
    }

    /**
     * @return mixed
     */
    public function getVkontakteId()
    {
        return $this->vkontakte_id;
    }

    /**
     * @return mixed
     */
    public function getFacebookId()
    {
        return $this->facebook_id;
    }

    /**
     * @return mixed
     */
    public function getFacebookAccessToken()
    {
        return $this->facebook_access_token;
    }

    /**
     * @param mixed $facebook_access_token
     */
    public function setFacebookAccessToken($facebook_access_token)
    {
        $this->facebook_access_token = $facebook_access_token;
    }

    /**
     * @param mixed $facebook_id
     */
    public function setFacebookId($facebook_id)
    {
        $this->facebook_id = $facebook_id;
    }

    /**
     * @param mixed $vkontakte_access_token
     */
    public function setVkontakteAccessToken($vkontakte_access_token)
    {
        $this->vkontakte_access_token = $vkontakte_access_token;
    }

    /**
     * @param mixed $vkontakte_id
     */
    public function setVkontakteId($vkontakte_id)
    {
        $this->vkontakte_id = $vkontakte_id;
    }


}