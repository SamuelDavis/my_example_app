<?php

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
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
    const EMAIL = 'email';
    const PASSWORD = 'password';
    const ROLES = 'roles';

    /** @var string */
    private $first_name;
    /** @var string */
    private $last_name;
    /** @var string */
    private $email;
    /** @var string */
    private $password;
    /** @var Collection */
    private $roles;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

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
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @param string|null $password
     * @return bool
     */
    public function hasPassword($password = null)
    {
        if ($password) {
            return password_verify($password, $this->password);
        }

        return !is_null($this->password);
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT);

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
        $builder->createField(static::EMAIL, Type::STRING)->unique()->build();
        $builder->addField(static::PASSWORD, Type::STRING);
        $builder->createManyToMany(static::ROLES, Role::class)->build();
    }

    public function getFullName()
    {
        return sprintf("%s %s", $this->getFirstName(), $this->getLastName());
    }
}
