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
     * @var \DateTime
     * @ORM\Column(name="date_released", type="datetime", nullable=false)
     * @DoctrineExtension\Timestampable(on="create")
     */
    protected $dateReleased;

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
