<?php

namespace App\Entities;

use DateTime;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

abstract class Entity
{
    const TABLE = 'entity';
    const ID = 'id';
    const CAT = 'created_at';
    const UAT = 'updated_at';

    /** @var int */
    protected $id;
    /** @var DateTime */
    protected $created_at;
    /** @var DateTime */
    protected $updated_at;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param DateTime $created_at
     */
    private function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param DateTime $updated_at
     */
    private function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    public function updateTimestamps()
    {
        $this->setUpdatedAt(new DateTime());

        if ($this->getCreatedAt() == null) {
            $this->setCreatedAt(new DateTime());
        }
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);
        $builder->setTable(static::TABLE);
        $builder->setMappedSuperClass();
        $builder->createField(static::ID, Type::INTEGER)->makePrimaryKey()->generatedValue()->build();
        $builder->createField(static::CAT, Type::DATETIME)->generatedValue()->build();
        $builder->createField(static::UAT, Type::DATETIME)->generatedValue()->build();
        $builder->addLifecycleEvent('updateTimestamps', Events::prePersist);
        $builder->addLifecycleEvent('updateTimestamps', Events::preUpdate);
    }
}
