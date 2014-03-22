<?php

namespace HeavyCodeGroup\LinkPub\StorageBundle\Doctrine\DBAL;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

abstract class AbstractEnumType extends Type
{
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
        }, $this->getAvailableValues())) . ') COMMENT \'(DC2Type:' . $this->getName() . ')\'';
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
            throw ConversionException::conversionFailed($value, $this->getName());
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
     * @return array
     */
    abstract protected function getAvailableValues();
}
