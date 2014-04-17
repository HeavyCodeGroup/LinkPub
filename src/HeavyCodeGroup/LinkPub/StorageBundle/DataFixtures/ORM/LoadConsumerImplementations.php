<?php

namespace HeavyCodeGroup\LinkPub\StorageBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use HeavyCodeGroup\LinkPub\StorageBundle\Entity\ConsumerImplementation;

class LoadConsumerImplementations extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        foreach ($this->getData() as $data) {
            $implementation = new ConsumerImplementation();
            $implementation->setId($data['id']);
            $implementation->setTitle($data['title']);
            $manager->persist($implementation);
        }

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 22;
    }

    protected function getData()
    {
        return array(
            array('id' => 'php', 'title' => 'PHP'),
            array('id' => 'perl', 'title' => 'Perl'),
        );
    }
}
