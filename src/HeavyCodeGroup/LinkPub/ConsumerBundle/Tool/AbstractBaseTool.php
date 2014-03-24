<?php

namespace HeavyCodeGroup\LinkPub\ConsumerBundle\Tool;

use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class AbstractBaseTool
{
    /**
     * @var ContainerInterface
     */
    private $container;


    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return ContainerInterface
     */
    protected function getContainer()
    {
        return $this->container;
    }
}
