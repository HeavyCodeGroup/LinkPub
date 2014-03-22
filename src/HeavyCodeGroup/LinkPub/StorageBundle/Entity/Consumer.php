<?php

namespace HeavyCodeGroup\LinkPub\StorageBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as DoctrineExtension;

/**
 * Class Consumer
 * @package HeavyCodeGroup\LinkPub\StorageBundle\Entity
 *
 * @ORM\Entity(repositoryClass="HeavyCodeGroup\LinkPub\StorageBundle\EntityRepository\ConsumerRepository")
 * @ORM\Table(name="consumer")
 */
class Consumer
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
     * @ORM\Column(name="guid", type="guid", length=36, unique=true)
     */
    protected $guid;

    /**
     * @var \DateTime
     * @ORM\Column(name="date_released", type="datetime", nullable=false)
     * @DoctrineExtension\Timestampable(on="create")
     */
    protected $dateReleased;

    /**
     * @var ConsumerImplementation
     * @ORM\JoinColumn(name="implementation", nullable=false)
     * @ORM\ManyToOne(targetEntity="ConsumerImplementation")
     */
    protected $implementation;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="ConsumerInstance", mappedBy="consumer")
     */
    protected $instances;

    /**
     * @var string
     * @ORM\Column(name="status", type="linkpub_enum_consumer_status")
     */
    protected $status;

    public function __construct()
    {
        $this->instances = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $guid
     * @return Consumer
     */
    public function setGuid($guid)
    {
        $this->guid = $guid;

        return $this;
    }

    /**
     * @return string
     */
    public function getGuid()
    {
        return $this->guid;
    }

    /**
     * @param \DateTime $dateReleased
     * @return Consumer
     */
    public function setDateReleased($dateReleased)
    {
        $this->dateReleased = $dateReleased;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateReleased()
    {
        return $this->dateReleased;
    }

    /**
     * @param ConsumerImplementation $implementation
     * @return Consumer
     */
    public function setImplementation($implementation)
    {
        $this->implementation = $implementation;

        return $this;
    }

    /**
     * @return ConsumerImplementation
     */
    public function getImplementation()
    {
        return $this->implementation;
    }

    /**
     * @return ArrayCollection|ConsumerInstance[]
     */
    public function getInstances()
    {
        return $this->instances;
    }

    /**
     * @param string $status
     * @return Consumer
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
}
