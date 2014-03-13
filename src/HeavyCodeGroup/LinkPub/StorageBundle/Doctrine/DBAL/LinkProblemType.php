<?php

namespace HeavyCodeGroup\LinkPub\StorageBundle\Doctrine\DBAL;

class LinkProblemType extends AbstractEnumType
{
    const ENUM_LINK_PROBLEM = 'linkpub_enum_link_problem';

    const PROBLEM_NOT_RESPONDING = 'not_responding';
    const PROBLEM_REFUSED        = 'refused';
    const PROBLEM_ERROR_CODE     = 'error_code';
    const PROBLEM_LINK_MISSING   = 'link_missing';

    /**
     * Gets the name of this type.
     *
     * @return string
     */
    public function getName()
    {
        return self::ENUM_LINK_PROBLEM;
    }

    /**
     * @return array
     */
    protected function getAvailableValues()
    {
        return array(
            self::PROBLEM_NOT_RESPONDING,
            self::PROBLEM_REFUSED,
            self::PROBLEM_ERROR_CODE,
            self::PROBLEM_LINK_MISSING,
        );
    }
}
