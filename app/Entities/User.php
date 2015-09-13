<?php

namespace App\Entities;

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

class User extends Entity
{
    const TABLE = 'users';
    const FIRST_NAME = 'first_name';
    const LAST_NAME = 'last_name';

    /** @var string */
    private $first_name;
    /** @var string */
    private $last_name;

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param string $last_name
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);
        $builder->setTable(static::TABLE);
        $builder->addField(static::FIRST_NAME, Type::STRING);
        $builder->addField(static::LAST_NAME, Type::STRING);
    }

    public function getFullName()
    {
        return sprintf("%s %s", $this->getFirstName(), $this->getLastName());
    }
}
