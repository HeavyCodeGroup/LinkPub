<?php

namespace HeavyCodeGroup\LinkPub\GuiBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use HeavyCodeGroup\LinkPub\GuiBundle\Entity\About;
use Symfony\Component\Yaml\Yaml;

class LoadAbout extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $data = $this->getData();

        foreach ($data as $aboutData) {
        $about = new About();

        $about->setTitle($aboutData['title']);
        $about->setBody($aboutData['body']);
        $manager->persist($about);
        }

        $manager->flush();
    }

    function getOrder()
    {
        return 40;
    }

    protected function getData()
    {
        return Yaml::parse(__DIR__ . '/data/about.yml');
    }
}