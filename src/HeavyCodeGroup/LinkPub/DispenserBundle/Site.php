<?php

namespace HeavyCodeGroup\LinkPub\DispenserBundle;
/**
 * Class Site
 * @package HeavyCodeGroup\LinkPub\DispenserBundle
 *
 * This is not an ORM entity. Not uses Entity namespace to avoid cognitive dissonance.
 */
class Site
{
    /**
     * @var Repository
     */
    protected $repository;

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var \DateTime
     */
    protected $dateLastObtain;

    /**
     * @var \DateTime
     */
    protected $dateLastUpdated;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $id
     * @return Site
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \DateTime|string $dateLastObtain
     * @return Site
     */
    public function setDateLastObtain($dateLastObtain)
    {
        if ($dateLastObtain instanceof \DateTime) {
            $this->dateLastObtain = $dateLastObtain;
        } elseif ($dateLastObtain) {
            $this->dateLastObtain = new \DateTime($dateLastObtain);
        } else {
            $this->dateLastObtain = false;
        }

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
     * @param \DateTime|string $dateLastUpdated
     * @return Site
     */
    public function setDateLastUpdated($dateLastUpdated)
    {
        if ($dateLastUpdated instanceof \DateTime) {
            $this->dateLastUpdated = $dateLastUpdated;
        } elseif ($dateLastUpdated) {
            $this->dateLastUpdated = new \DateTime($dateLastUpdated);
        } else {
            $this->dateLastUpdated = false;
        }

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateLastUpdated()
    {
        return $this->dateLastUpdated;
    }

    /**
     * @param integer $dispenseInterval
     * @return boolean
     */
    public function isAllowedToDispense($dispenseInterval)
    {
        if ($this->dateLastObtain instanceof \DateTime) {
            $dateLastObtain = clone $this->dateLastObtain;
            $dateLastObtain->modify(sprintf('+%d seconds', $dispenseInterval));
            if (new \DateTime('now') < $dateLastObtain) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return array
     */
    public function getLinkData()
    {
        return $this->repository->getLinkDataOfSite($this);
    }
}
