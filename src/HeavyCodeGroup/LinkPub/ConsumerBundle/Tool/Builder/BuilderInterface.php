<?php

namespace HeavyCodeGroup\LinkPub\ConsumerBundle\Tool\Builder;

use HeavyCodeGroup\LinkPub\StorageBundle\Entity\ConsumerInstance;

interface BuilderInterface
{
    public function build(ConsumerInstance $consumer);
}
