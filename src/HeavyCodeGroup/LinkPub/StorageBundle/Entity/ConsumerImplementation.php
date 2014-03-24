<?php

namespace HeavyCodeGroup\LinkPub\StorageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class ConsumerImplementation
 * @package HeavyCodeGroup\LinkPub\StorageBundle\Entity
 *
 * @ORM\Entity(repositoryClass="HeavyCodeGroup\LinkPub\StorageBundle\EntityRepository\ConsumerImplementationRepository")
 * @ORM\Table(name="consumer_implementation")
 */
class ConsumerImplementation
{
    /**
     * @var string
     * @ORM\Column(name="id", type="string")
     * @ORM\Id
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="title", type="string")
     */
    protected $title;

    /**
     * @param string $id
     * @return ConsumerImplementation
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $title
     * @return ConsumerImplementation
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
}
