<?php

declare(strict_types=1);

namespace Arcmedia\Shared\Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

abstract class DoctrineRepository
{
    protected EntityRepository $repository;
    protected string $table;

    public function __construct(protected readonly EntityManager $entityManager)
    {
        $this->repository = $this->entityManager->getRepository($this->entityClassName());
        $this->table = $this->entityManager->getClassMetadata($this->entityClassName())->getTableName();
    }

    abstract protected function entityClassName(): string;
}