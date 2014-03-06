<?php

namespace HeavyCodeGroup\LinkPub\StorageBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Page
 * @package HeavyCodeGroup\LinkPub\StorageBundle\Entity
 *
 * @ORM\Entity(repositoryClass="HeavyCodeGroup\LinkPub\StorageBundle\Entity\PageRepository")
 * @ORM\Table(name="page")
 */
class Page
{
    /**
     * @var integer
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Site
     * @ORM\JoinColumn(name="site_id", nullable=false)
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="pages")
     */
    protected $site;

    /**
     * @var string
     * @ORM\Column(name="url", type="string", length=1024)
     */
    protected $url;

    /**
     * @var string
     * @ORM\Column(name="state", type="linkpub_enum_page_status")
     */
    protected $state;

    /**
     * @var integer
     * @ORM\Column(name="level", type="decimal", precision=1)
     */
    protected $level;

    /**
     * @var integer
     * @ORM\Column(name="page_rank", type="decimal", precision=2, nullable=true)
     */
    protected $pageRank;

    /**
     * @var integer
     * @ORM\Column(name="capacity", type="decimal", precision=2)
     */
    protected $capacity;

    /**
     * @var float
     * @ORM\Column(name="price", type="float")
     */
    protected $price;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Link", mappedBy="page")
     */
    protected $linksOn;

    /**
     * @var ArrayCollection
     * @ORM\JoinTable(name="page_connection",
     *      joinColumns={@ORM\JoinColumn(name="child_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="parent_id", referencedColumnName="id")}
     * )
     * @ORM\ManyToMany(targetEntity="Page", inversedBy="children")
     */
    protected $parents;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Page", mappedBy="parents")
     */
    protected $children;

    public function __construct()
    {
        $this->linksOn = new ArrayCollection();
        $this->parents = new ArrayCollection();
        $this->children = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Site $site
     * @return Page
     */
    public function setSite($site)
    {
        $this->site = $site;

        return $this;
    }

    /**
     * @return Site
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * @param string $url
     * @return Page
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $state
     * @return Page
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param int $level
     * @return Page
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param int $pageRank
     * @return Page
     */
    public function setPageRank($pageRank)
    {
        $this->pageRank = $pageRank;

        return $this;
    }

    /**
     * @return int
     */
    public function getPageRank()
    {
        return $this->pageRank;
    }

    /**
     * @param int $capacity
     * @return Page
     */
    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;

        return $this;
    }

    /**
     * @return int
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * @param float $price
     * @return Page
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return ArrayCollection
     */
    public function getLinksOn()
    {
        return $this->linksOn;
    }

    /**
     * @param Page $parent
     * @return Page
     */
    public function addParent($parent)
    {
        $this->parents->add($parent);
        $parent->getChildren()->add($this);

        return $this;
    }

    /**
     * @param Page $parent
     * @return Page
     */
    public function removeParent($parent)
    {
        $this->parents->removeElement($parent);
        $this->getChildren()->add($this);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getParents()
    {
        return $this->parents;
    }

    /**
     * @param Page $child
     * @return Page
     */
    public function addChild($child)
    {
        $this->children->add($child);
        $child->getParents()->add($this);

        return $this;
    }

    /**
     * @param Page $child
     * @return Page
     */
    public function removeChild($child)
    {
        $this->children->removeElement($child);
        $child->getParents()->removeElement($this);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getChildren()
    {
        return $this->children;
    }
}
