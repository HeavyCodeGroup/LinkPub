<?php

namespace HeavyCodeGroup\LinkPub\StorageBundle\DBAL;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

class PageStatusType extends Type
{
    const ENUM_PAGE_STATUS = 'linkpub_enum_page_status';

    const STATUS_ACTIVE   = 'active';
    const STATUS_DISABLED = 'disabled';

    /**
     * Gets the SQL declaration snippet for a field of this type.
     *
     * @param array $fieldDeclaration The field declaration.
     * @param AbstractPlatform $platform The currently used database platform.
     * @return string
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return 'ENUM(' . implode(',', array_map(function ($val) {
            return "'" . $val . "'";
        }, $this->getAvailableValues())) . ')';
    }

    /**
     * @param string $value
     * @param AbstractPlatform $platform
     * @return string
     * @throws ConversionException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (!in_array($value, $this->getAvailableValues())) {
            throw ConversionException::conversionFailed($value, self::ENUM_PAGE_STATUS);
        }

        return $value;
    }

    /**
     * @param string $value
     * @param AbstractPlatform $platform
     * @return string
     * @throws \InvalidArgumentException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (!in_array($value, $this->getAvailableValues())) {
            throw new \InvalidArgumentException("Invalid status");
        }

        return $value;
    }

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
    private function getAvailableValues()
    {
        return array(
            self::STATUS_ACTIVE,
            self::STATUS_DISABLED,
        );
    }
}
 