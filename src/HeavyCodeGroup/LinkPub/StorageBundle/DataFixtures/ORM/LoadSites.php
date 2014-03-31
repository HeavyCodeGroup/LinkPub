<?php

namespace HeavyCodeGroup\LinkPub\StorageBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use HeavyCodeGroup\LinkPub\StorageBundle\Entity\Page;
use HeavyCodeGroup\LinkPub\StorageBundle\Entity\Site;
use Symfony\Component\Yaml\Yaml;

class LoadSites extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $data = $this->getData();

        foreach ($data as $siteData) {
            $site = new Site();
            $site->setCategory($this->getReference('category_' . $siteData['category']));
            $site->setTitle($siteData['title']);
            $site->setRootUrl($siteData['url']);
            $site->setOwner($this->getReference('user_user1'));
            $manager->persist($site);
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
        return 21;
    }

    protected function getData()
    {
        return Yaml::parse(__DIR__ . '/data/sites.yml');
    }
}
