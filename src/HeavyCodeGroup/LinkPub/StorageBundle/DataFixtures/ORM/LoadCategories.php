<?php

namespace HeavyCodeGroup\LinkPub\StorageBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use HeavyCodeGroup\LinkPub\StorageBundle\Entity\Category;
use Symfony\Component\Yaml\Yaml;

class LoadCategories extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $data = $this->getData();
        $i = 0;

        foreach ($data as $categoryName) {
            $category = new Category();
            $category->setTitle($categoryName);
            $manager->persist($category);
            $this->addReference('category_' . (++$i), $category);

            $subData = $this->getData($i);
            $j = 0;
            foreach ($subData as $subcategoryName) {
                $subCategory = new Category();
                $subCategory->setTitle($subcategoryName);
                $subCategory->setParent($category);
                $manager->persist($subCategory);
                $this->addReference('category_' . $i . '_' . (++$j), $subCategory);
            }
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
        return 20;
    }

    protected function getData($parent = null)
    {
        $filename = __DIR__ . '/data/categories' . (($parent !== null) ? '_' . $parent : '') . '.yml';

        if (!file_exists($filename)) {
            return array();
        }

        return Yaml::parse($filename);
    }
}
