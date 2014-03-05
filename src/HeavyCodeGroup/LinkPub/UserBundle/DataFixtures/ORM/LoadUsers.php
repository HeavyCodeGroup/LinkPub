<?php

namespace HeavyCodeGroup\LinkPub\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use HeavyCodeGroup\LinkPub\UserBundle\Entity\User;

class LoadUsers extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin->setUsername('admin');
        $admin->setEmail('admin@mail.net');
        $admin->setPlainPassword('admin');
        $admin->setEnabled(true);
        $admin->setSuperAdmin(true);
        $manager->persist($admin);

        $user1 = new User();
        $user1->setUsername('user1');
        $user1->setEmail('user1@mail.net');
        $user1->setPlainPassword('user1');
        $user1->setEnabled(true);
        $user1->setSuperAdmin(false);
        $manager->persist($user1);

        $manager->flush();

        $this->setReference('user_admin', $admin);
        $this->setReference('user_user1', $user1);
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
}
