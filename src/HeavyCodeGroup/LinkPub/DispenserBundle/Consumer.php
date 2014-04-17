<?php

namespace HeavyCodeGroup\LinkPub\DispenserBundle;

/**
 * Class Consumer
 * @package HeavyCodeGroup\LinkPub\DispenserBundle
 *
 * This is not an ORM entity. Not uses Entity namespace to avoid cognitive dissonance.
 */
class Consumer
{
    const STATUS_ACTIVE = 'active';
    const STATUS_DEPRECATED = 'deprecated';
    const STATUS_DISABLED = 'disabled';

    /**
     * @var Repository
     */
    protected $repository;

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $status;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $id
     * @return Consumer
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

    /**
     * @return bool
     */
    public function isDisabled()
    {
        return ($this->status == self::STATUS_DISABLED);
    }

    /**
     * @return bool
     */
    public function isDeprecated()
    {
        return ($this->status == self::STATUS_DEPRECATED);
    }
}
