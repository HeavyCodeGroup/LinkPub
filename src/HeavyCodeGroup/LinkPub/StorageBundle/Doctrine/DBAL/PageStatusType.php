<?php

namespace HeavyCodeGroup\LinkPub\StorageBundle\Doctrine\DBAL;

class PageStatusType extends AbstractEnumType
{
    const ENUM_PAGE_STATUS = 'linkpub_enum_page_status';

    const STATUS_ACTIVE   = 'active';
    const STATUS_DISABLED = 'disabled';

    /**
     * Gets the name of this type.
     *
     * @return string
     */
    public function getName()
    {
        return self::ENUM_PAGE_STATUS;
    }

    /**
     * @return array
     */
    protected function getAvailableValues()
    {
        return array(
            self::STATUS_ACTIVE,
            self::STATUS_DISABLED,
        );
    }
}
