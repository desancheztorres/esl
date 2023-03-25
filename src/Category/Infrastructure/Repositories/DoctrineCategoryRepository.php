<?php

declare(strict_types=1);

namespace App\Category\Infrastructure\Repositories;

use App\Category\Domain\Category;
use App\Category\Domain\Contracts\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Category as CategoryEntity;

final class DoctrineCategoryRepository implements CategoryRepository
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function save(Category $category): void
    {
        $categoryEntity = new CategoryEntity();
        $categoryEntity->setId($category->id()->value());
        $categoryEntity->setErpId($category->erpId()->value());
        $categoryEntity->setName($category->name()->value());
        $categoryEntity->setParent($category->parent()->value());
        $categoryEntity->setIsActive($category->isActive()->value());

        $this->entityManager->persist($categoryEntity);
        $this->entityManager->flush();
    }

    /**
     * @param Category[] $categories
     */
    public function saveMany(array $categories): void
    {
        $batchSize = 10;

        foreach ($categories as $key => $category) {
            $categoryEntity = new CategoryEntity();
            $categoryEntity->setId($category->id()->value());
            $categoryEntity->setErpId($category->erpId()->value());
            $categoryEntity->setName($category->name()->value());
            $categoryEntity->setParent($category->parent()->value());
            $categoryEntity->setIsActive($category->isActive()->value());

            $this->entityManager->persist($categoryEntity);

            if (($key % $batchSize) === 0) {
                 $this->entityManager->flush();
                 $this->entityManager->clear();
            }
        }
    }
}