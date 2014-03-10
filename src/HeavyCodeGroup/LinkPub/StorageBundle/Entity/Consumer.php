<?php

namespace HeavyCodeGroup\LinkPub\StorageBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as DoctrineExtension;

/**
 * Class Consumer
 * @package HeavyCodeGroup\LinkPub\StorageBundle\Entity
 *
 * @ORM\Entity(repositoryClass="HeavyCodeGroup\LinkPub\StorageBundle\Entity\ConsumerRepository")
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
     * @var boolean
     * @ORM\Column(name="is_deprecated", type="boolean")
     */
    protected $isDeprecated;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="ConsumerInstance", mappedBy="consumer")
     */
    protected $instances;

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
     * @param boolean $isDeprecated
     * @return Consumer
     */
    public function setIsDeprecated($isDeprecated)
    {
        $this->isDeprecated = $isDeprecated;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsDeprecated()
    {
        return $this->isDeprecated;
    }

    /**
     * @return ArrayCollection
     */
    public function getInstances()
    {
        return $this->instances;
    }
}
