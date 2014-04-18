<?php

namespace HeavyCodeGroup\LinkPub\StorageBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use HeavyCodeGroup\LinkPub\StorageBundle\Entity\Page;
use HeavyCodeGroup\LinkPub\StorageBundle\Entity\Site;
use Symfony\Component\Yaml\Yaml;

class LoadPage extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $data = $this->getData();

        foreach ($data as $pageData) {
            $page = new Page();
            $page->setUrl($pageData['url']);
            $page->setLevel($pageData['level']);
            $page->setPrice($pageData['price']);
            $page->setCapacity($pageData['capacity']);
            $page->setPageRank($pageData['page_rank']);
            $page->setState($pageData['state']);

            $page->setSite($this->getReference($pageData['referenceSite']));
            $manager->persist($page);

            $manager->flush();
        }

    }
    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 23;
    }

    protected function getData()
    {
        return Yaml::parse(__DIR__ . '/data/page.yml');
    }
}