<?php

namespace HeavyCodeGroup\LinkPub\StorageBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Site
 * @package HeavyCodeGroup\LinkPub\StorageBundle\Entity
 *
 * @ORM\Entity(repositoryClass="HeavyCodeGroup\LinkPub\StorageBundle\EntityRepository\SiteRepository")
 * @ORM\Table(name="site")
 * @ORM\HasLifecycleCallbacks()
 */
class Site
{
    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Category
     * @ORM\JoinColumn(name="category_id", nullable=false)
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="sites")
     */
    protected $category;

    /**
     * @var \HeavyCodeGroup\LinkPub\UserBundle\Entity\User
     * @ORM\JoinColumn(name="owner_id", nullable=false)
     * @ORM\ManyToOne(targetEntity="HeavyCodeGroup\LinkPub\UserBundle\Entity\User")
     */
    protected $owner;

    /**
     * @var string
     * @ORM\Column(name="title", type="string")
     */
    protected $title;

    /**
     * @var string
     * @ORM\Column(name="root_url", type="string")
     */
    protected $rootUrl;

    /**
     * @var integer
     * @ORM\Column(name="tci", type="integer", nullable=true)
     */
    protected $tci;

    /**
     * @var \DateTime
     * @ORM\Column(name="date_last_index", type="datetime", nullable=true)
     */
    protected $dateLastIndex;

    /**
     * @var \DateTime
     * @ORM\Column(name="date_last_obtain", type="datetime", nullable=true)
     */
    protected $dateLastObtain;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Page", mappedBy="site")
     */
    protected $pages;

    /**
     * @var Page
     * @ORM\JoinColumn(name="root_page_id")
     * @ORM\OneToOne(targetEntity="Page")
     */
    protected $rootPage;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="ConsumerInstance", mappedBy="site")
     */
    protected $consumerInstances;

    /**
     * @var boolean
     * @ORM\Column(name="is_using_deprecated_consumer", type="boolean", nullable=true)
     */
    protected $isUsingDeprecatedConsumer;

    public function __construct()
    {
        $this->pages = new ArrayCollection();
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Category $category
     * @return Site
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param \HeavyCodeGroup\LinkPub\UserBundle\Entity\User $owner
     * @return Site
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return \HeavyCodeGroup\LinkPub\UserBundle\Entity\User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param string $title
     * @return Site
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
     * @param string $rootUrl
     * @return Site
     */
    public function setRootUrl($rootUrl)
    {
        $this->rootUrl = $rootUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getRootUrl()
    {
        return $this->rootUrl;
    }

    /**
     * @param int $tci
     * @return Site
     */
    public function setTci($tci)
    {
        $this->tci = $tci;

        return $this;
    }

    /**
     * @return int
     */
    public function getTci()
    {
        return $this->tci;
    }

    /**
     * @param \DateTime $dateLastIndex
     * @return Site
     */
    public function setDateLastIndex($dateLastIndex)
    {
        $this->dateLastIndex = $dateLastIndex;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateLastIndex()
    {
        return $this->dateLastIndex;
    }

    /**
     * @param \DateTime $dateLastObtain
     * @return Site
     */
    public function setDateLastObtain($dateLastObtain)
    {
        $this->dateLastObtain = $dateLastObtain;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateLastObtain()
    {
        return $this->dateLastObtain;
    }

    /**
     * @param Page $page
     * @return $this
     */
    public function addPage($page)
    {
        $this->pages->add($page);

        return $this;
    }

    /**
     * @param Page $page
     * @return $this
     */
    public function removePage($page)
    {
        $this->pages->removeElement($page);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * @param Page $rootPage
     * @return Site
     */
    public function setRootPage($rootPage)
    {
        $this->rootPage = $rootPage;

        return $this;
    }

    /**
     * @return Page
     */
    public function getRootPage()
    {
        return $this->rootPage;
    }

    /**
     * @return ArrayCollection
     */
    public function getConsumerInstances()
    {
        return $this->consumerInstances;
    }

    /**
     * @param boolean $isUsingDeprecatedConsumer
     * @return Site
     */
    public function setIsUsingDeprecatedConsumer($isUsingDeprecatedConsumer)
    {
        $this->isUsingDeprecatedConsumer = $isUsingDeprecatedConsumer;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsUsingDeprecatedConsumer()
    {
        return $this->isUsingDeprecatedConsumer;
    }

}
