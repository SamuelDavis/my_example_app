<?php

namespace App\Entities;

use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

class User extends Entity
{
    const TABLE = 'users';
    const FIRST_NAME = 'first_name';
    const LAST_NAME = 'last_name';
    const ROLES = 'roles';

    /** @var string */
    private $first_name;
    /** @var string */
    private $last_name;
    /** @var Collection */
    private $roles;

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     * @return $this
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;

        return $this;
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
     * @return $this
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;

        return $this;
    }

    /**
     * @return Role[]
     */
    public function getRoles()
    {
        return $this->roles->toArray();
    }

    public function hasRole(Role $role)
    {
        return $this->roles->contains($role);
    }

    public function addRole(Role $role)
    {
        if (!$this->hasRole($role)) {
            $this->roles->add($role);
        }

        return $this;
    }

    public function removeRole(Role $role)
    {
        if ($this->hasRole($role)) {
            $this->roles->removeElement($role);
        }

        return $this;
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);
        $builder->setTable(static::TABLE);
        $builder->addField(static::FIRST_NAME, Type::STRING);
        $builder->addField(static::LAST_NAME, Type::STRING);
        $builder->createManyToMany(static::ROLES, Role::class)->build();
    }

    public function getFullName()
    {
        return sprintf("%s %s", $this->getFirstName(), $this->getLastName());
    }
}
