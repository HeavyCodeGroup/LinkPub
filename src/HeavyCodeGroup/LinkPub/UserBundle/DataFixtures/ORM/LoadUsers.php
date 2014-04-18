<?php

namespace HeavyCodeGroup\LinkPub\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use HeavyCodeGroup\LinkPub\UserBundle\Entity\User;
use Symfony\Component\Yaml\Yaml;

class LoadUsers extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {

        $data = $this->getData();

        foreach ($data as $userData) {
            $user = new User();

            $user->setUsername($userData['username']);
            $user->setEmail($userData['email']);
            $user->setPlainPassword($userData['plainPassword']);
            $user->setEnabled($userData['enabled']);
            $user->setSuperAdmin($userData['superAdmin']);
            $manager->persist($user);
            $manager->flush();
            $this->setReference($userData['reference'], $user);
        }

//        $manager->flush();
//
//        $admin = new User();
//        $admin->setUsername('admin');
//        $admin->setEmail('admin@mail.net');
//        $admin->setPlainPassword('admin');
//        $admin->setEnabled(true);
//        $admin->setSuperAdmin(true);
//        $manager->persist($admin);
//
//        $user1 = new User();
//        $user1->setUsername('user1');
//        $user1->setEmail('user1@mail.net');
//        $user1->setPlainPassword('user1');
//        $user1->setEnabled(true);
//        $user1->setSuperAdmin(false);
//        $manager->persist($user1);
//
//        $manager->flush();
//
//        $this->setReference('user_admin', $admin);
//        $this->setReference('user_user1', $user1);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 10;
    }

    protected function getData()
    {
        return Yaml::parse(__DIR__ . '/data/user.yml');
    }
}
