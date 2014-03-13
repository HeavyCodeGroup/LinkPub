<?php

namespace HeavyCodeGroup\LinkPub\StorageBundle\Doctrine\DBAL;

class ConsumerStatusType extends AbstractEnumType
{
    const ENUM_CONSUMER_STATUS = 'linkpub_enum_consumer_status';

    const STATUS_ACTIVE     = 'active';
    const STATUS_DEPRECATED = 'deprecated';
    const STATUS_DISABLED   = 'disabled';

    /**
     * Gets the name of this type.
     *
     * @return string
     */
    public function getName()
    {
        return self::ENUM_CONSUMER_STATUS;
    }

    /**
     * @return array
     */
    protected function getAvailableValues()
    {
        return array(
            self::STATUS_ACTIVE,
            self::STATUS_DEPRECATED,
            self::STATUS_DISABLED,
        );
    }
}
