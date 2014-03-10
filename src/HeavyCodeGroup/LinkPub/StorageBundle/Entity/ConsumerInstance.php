<?php

namespace HeavyCodeGroup\LinkPub\StorageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class ConsumerInstance
 * @package HeavyCodeGroup\LinkPub\StorageBundle\Entity
 *
 * @ORM\Entity(repositoryClass="HeavyCodeGroup\LinkPub\StorageBundle\Entity\ConsumerInstanceRepository")
 * @ORM\Table(name="consumer_instance")
 */
class ConsumerInstance
{
    /**
     * @var string
     * @ORM\Column(name="guid", type="guid", length=36)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $guid;

    /**
     * @var Site
     * @ORM\JoinColumn(name="site_id", nullable=false)
     * @ORM\ManyToOne(targetEntity="Site", inversedBy="consumerInstances")
     */
    protected $site;

    /**
     * @var Consumer
     * @ORM\JoinColumn(name="consumer_id", nullable=false)
     * @ORM\ManyToOne(targetEntity="Consumer", inversedBy="instances")
     */
    protected $consumer;

    /**
     * @return string
     */
    public function getGuid()
    {
        return $this->guid;
    }

    /**
     * @param Site $site
     * @return ConsumerInstance
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
     * @param Consumer $consumer
     * @return ConsumerInstance
     */
    public function setConsumer($consumer)
    {
        $this->consumer = $consumer;

        return $this;
    }

    /**
     * @return Consumer
     */
    public function getConsumer()
    {
        return $this->consumer;
    }
}
