<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Category\Infrastructure\Persistence\Doctrine\Repository;

use Arcmedia\Esl\Category\Domain\Category;
use Arcmedia\Esl\Category\Domain\CategoryCollection;
use Arcmedia\Esl\Category\Domain\Contract\CategoryRepository;
use Arcmedia\Esl\Category\Domain\ValueObject\CategoryId;
use Arcmedia\Esl\Category\Domain\ValueObject\CategoryIsActive;
use Arcmedia\Esl\Category\Domain\ValueObject\CategoryLevel;
use Arcmedia\Esl\Category\Domain\ValueObject\CategoryName;
use Arcmedia\Esl\Category\Domain\ValueObject\CategoryParent;
use Arcmedia\Esl\Category\Infrastructure\Persistence\Doctrine\Entity\Category as CategoryEntity;
use Doctrine\ORM\Exception\ORMException;

final class DoctrineCategoryRepository extends DoctrineRepository implements CategoryRepository
{
    protected function entityClassName(): string
    {
        return CategoryEntity::class;
    }

    public function findAll(): CategoryCollection
    {
        $categories = $this->repository->findAll();

        $categoryCollection = CategoryCollection::init();

        if (!empty($categories)) {
            foreach ($categories as $category) {
                $categoryCollection->add($this->toDomain($category));
            }
        }

        return $categoryCollection;
    }

    public function save(Category $category): void
    {
        try {
            $this->entityManager->persist($this->toEntity($category));
            $this->entityManager->flush();
        } catch (ORMException $e) {
            var_dump($e->getMessage());
        }
    }

    private function toEntity(Category $category): CategoryEntity
    {
        return new CategoryEntity(
            id: $category->id()->value(),
            name: $category->name()->value(),
            parent: $category->parent()->value(),
            is_active: $category->isActive()->value(),
            level: $category->level()->value(),
            created_at: $category->createdAt(),
            updated_at: $category->updatedAt()
        );
    }

    private function toDomain(CategoryEntity $category): Category
    {
        return new Category(
            id: new CategoryId($category->id()),
            name: new CategoryName($category->name()),
            parent: new CategoryParent($category->parent()),
            isActive: new CategoryIsActive($category->isActive()),
            level: new CategoryLevel($category->level()),
        );
    }
}