<?php

namespace App\Repositories;

use App\Entities\Entity;
use App\Entities\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

abstract class Repository
{
    const ENTITY = '';

    /** @var EntityManager */
    protected $entityManager;
    /** @var EntityRepository */
    protected $repo;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repo = $entityManager->getRepository(static::ENTITY);
    }

    public function get($id = null)
    {
        return $this->repo->find($id);
    }

    public function getAll()
    {
        return $this->repo->findAll();
    }

    public function add(Entity $entity)
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function remove($user)
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }

    public function build()
    {
        $entity = static::ENTITY;
        return new $entity();
    }
}
