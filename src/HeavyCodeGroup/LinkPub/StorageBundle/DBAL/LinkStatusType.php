<?php

namespace HeavyCodeGroup\LinkPub\StorageBundle\DBAL;

class LinkStatusType extends AbstractEnumType
{
    const ENUM_LINK_STATUS = 'linkpub_enum_link_status';

    const STATUS_ACTIVE       = 'active';
    const STATUS_SLEEPING     = 'sleeping';
    const STATUS_SITE_DOWN    = 'site_down';
    const STATUS_LINK_MISSING = 'link_missing';

    /**
     * Gets the name of this type.
     *
     * @return string
     */
    public function getName()
    {
        return self::ENUM_LINK_STATUS;
    }

    /**
     * @return array
     */
    protected function getAvailableValues()
    {
        return array(
            self::STATUS_ACTIVE,
            self::STATUS_SLEEPING,
            self::STATUS_SITE_DOWN,
            self::STATUS_LINK_MISSING,
        );
    }
}
