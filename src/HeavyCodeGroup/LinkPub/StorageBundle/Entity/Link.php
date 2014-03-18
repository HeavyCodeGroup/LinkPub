<?php

namespace HeavyCodeGroup\LinkPub\StorageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Link
 * @package HeavyCodeGroup\LinkPub\StorageBundle\Entity
 *
 * @ORM\Entity(repositoryClass="HeavyCodeGroup\LinkPub\StorageBundle\EntityRepository\LinkRepository")
 * @ORM\Table(name="link")
 */
class Link
{
    /**
     * @var integer
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \HeavyCodeGroup\LinkPub\UserBundle\Entity\User
     * @ORM\JoinColumn(name="owner_id", nullable=false)
     * @ORM\ManyToOne(targetEntity="HeavyCodeGroup\LinkPub\UserBundle\Entity\User")
     */
    protected $owner;

    /**
     * @var Page
     * @ORM\JoinColumn(name="page_id", nullable=false)
     * @ORM\ManyToOne(targetEntity="Page", inversedBy="linksOn")
     */
    protected $page;

    /**
     * @var string
     * @ORM\Column(name="url", type="string", length=1024)
     */
    protected $url;

    /**
     * @var string
     * @ORM\Column(name="title", type="string")
     */
    protected $title;

    /**
     * @var string
     * @ORM\Column(name="description", type="string")
     */
    protected $description;

    /**
     * @var \DateTime
     * @ORM\Column(name="date_start", type="datetime", nullable=true)
     */
    protected $dateStart;

    /**
     * @var \DateTime
     * @ORM\Column(name="date_end", type="datetime", nullable=true)
     */
    protected $dateEnd;

    /**
     * @var float
     * @ORM\Column(name="price", type="float")
     */
    protected $price;

    /**
     * @var Page
     * @ORM\JoinColumn(name="track_page_id", nullable=true)
     * @ORM\ManyToOne(targetEntity="Page", inversedBy="linksTracked")
     */
    protected $trackPage;

    /**
     * @var \DateTime
     * @ORM\Column(name="date_last_checked", type="datetime", nullable=true)
     */
    protected $dateLastChecked;

    /**
     * @var \DateTime
     * @ORM\Column(name="date_last_scored", type="datetime", nullable=true)
     */
    protected $dateLastScored;

    /**
     * @var string
     * @ORM\Column(name="state", type="linkpub_enum_link_status")
     */
    protected $state;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \HeavyCodeGroup\LinkPub\UserBundle\Entity\User $owner
     * @return Link
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
     * @param Page $page
     * @return Link
     */
    public function setPage($page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @return Page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param string $url
     * @return Link
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
     * @param string $title
     * @return Link
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
     * @param string $description
     * @return Link
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param \DateTime $dateStart
     * @return Link
     */
    public function setDateStart($dateStart)
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * @param \DateTime $dateEnd
     * @return Link
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * @param float $price
     * @return Link
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
     * @param Page $trackPage
     * @return Link
     */
    public function setTrackPage($trackPage)
    {
        $this->trackPage = $trackPage;

        return $this;
    }

    /**
     * @return Page
     */
    public function getTrackPage()
    {
        return $this->trackPage;
    }

    /**
     * @param \DateTime $dateLastChecked
     * @return Link
     */
    public function setDateLastChecked($dateLastChecked)
    {
        $this->dateLastChecked = $dateLastChecked;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateLastChecked()
    {
        return $this->dateLastChecked;
    }

    /**
     * @param \DateTime $dateLastScored
     * @return Link
     */
    public function setDateLastScored($dateLastScored)
    {
        $this->dateLastScored = $dateLastScored;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateLastScored()
    {
        return $this->dateLastScored;
    }

    /**
     * @param string $state
     * @return Link
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

}
