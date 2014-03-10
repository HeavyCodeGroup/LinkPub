<?php

namespace HeavyCodeGroup\LinkPub\StorageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as DoctrineExtension;

/**
 * Class LinkProblem
 * @package HeavyCodeGroup\LinkPub\StorageBundle\Entity
 *
 * @ORM\Entity(repositoryClass="HeavyCodeGroup\LinkPub\StorageBundle\EntityRepository\LinkProblemRepository")
 * @ORM\Table(name="link_problem")
 */
class LinkProblem
{
    /**
     * @var integer
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Link
     * @ORM\JoinColumn(name="link_id", nullable=false)
     * @ORM\ManyToOne(targetEntity="Page")
     */
    protected $link;

    /**
     * @var \DateTime
     * @ORM\Column(name="date_start", type="datetime", nullable=false)
     * @DoctrineExtension\Timestampable(on="create")
     */
    protected $dateStart;

    /**
     * @var \DateTime
     * @ORM\Column(name="date_end", type="datetime", nullable=true)
     */
    protected $dateEnd;

    /**
     * @var string
     * @ORM\Column(name="type", type="linkpub_enum_link_problem")
     */
    protected $type;

    /**
     * @var array
     * @ORM\Column(name="data", type="json_array", nullable=true)
     */
    protected $data;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Link $link
     * @return LinkProblem
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return Link
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param \DateTime $dateStart
     * @return LinkProblem
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
     * @return LinkProblem
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
     * @param string $type
     * @return LinkProblem
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param array $data
     * @return LinkProblem
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

}
 