<?php

namespace HeavyCodeGroup\LinkPub\StorageBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Category
 * @package HeavyCodeGroup\LinkPub\LinkPubStorageBundle\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="category")
 */
class Category
{
    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="title", type="string")
     */
    protected $title;

    /**
     * @var Category
     * @ORM\ManyToOne(targetEntity="Category", cascade={"persist"}, inversedBy="children")
     */
    protected $parent;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
     */
    protected $children;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Site", mappedBy="category")
     */
    protected $sites;

    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->sites    = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $title
     * @return Category
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param Category $parent
     * @return Category
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Category
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param Category $child
     * @return Category
     */
    public function addChild($child) {
        $this->children->add($child);

        return $this;
    }

    /**
     * @param Category $child
     * @return Category
     */
    public function removeChild($child) {
        $this->children->removeElement($child);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param Site $site
     * @return Category
     */
    public function addSite($site)
    {
        $this->sites->add($site);

        return $this;
    }

    /**
     * @param Site $site
     * @return Category
     */
    public function removeSite($site)
    {
        $this->sites->removeElement($site);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getSites()
    {
        return $this->sites;
    }

}
