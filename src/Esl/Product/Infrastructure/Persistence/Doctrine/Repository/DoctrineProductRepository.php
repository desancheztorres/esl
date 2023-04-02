<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Product\Infrastructure\Persistence\Doctrine\Repository;

use Arcmedia\Esl\Product\Domain\Contract\ProductRepository;
use Arcmedia\Esl\Product\Domain\Product;
use Arcmedia\Esl\Product\Domain\ProductCollection;
use Arcmedia\Esl\Product\Domain\ValueObject\ProductId;
use Arcmedia\Esl\Product\Domain\ValueObject\ProductName;
use Arcmedia\Esl\Product\Domain\ValueObject\ProductPrice;
use Arcmedia\Esl\Product\Domain\ValueObject\ProductSku;
use Arcmedia\Esl\Product\Domain\ValueObject\ProductStatus;
use Arcmedia\Esl\Product\Domain\ValueObject\ProductVisibility;
use Arcmedia\Esl\Product\Infrastructure\Persistence\Doctrine\Entity\Product as ProductEntity;
use Arcmedia\Shared\Infrastructure\Persistence\Doctrine\Repository\DoctrineRepository;
use Doctrine\ORM\Exception\ORMException;

final class DoctrineProductRepository extends DoctrineRepository implements ProductRepository
{
    protected function entityClassName(): string
    {
        return ProductEntity::class;
    }

    public function findAll(): ProductCollection
    {
        $products = $this->repository->findAll();

        $productCollection = ProductCollection::init();

        if (!empty($products)) {
            foreach ($products as $product) {
                $productCollection->add($this->toDomain($product));
            }
        }

        return $productCollection;
    }

    public function save(Product $product): void
    {
        try {
            $this->entityManager->persist($this->toEntity($product));
            $this->entityManager->flush();
        } catch (ORMException $e) {
            var_dump($e->getMessage());
        }
    }

    private function toDomain(ProductEntity $product): Product
    {
        return new Product(
            id: new ProductId($product->id()),
            sku: new ProductSku($product->sku()),
            name: new ProductName($product->name()),
            price: new ProductPrice($product->price()),
            status: new ProductStatus($product->status()),
            visibility: new ProductVisibility($product->visibility())
        );
    }

    private function toEntity(Product $product): ProductEntity
    {
        return new ProductEntity(
            id: $product->id()->value(),
            sku: $product->sku()->value(),
            name: $product->name()->value(),
            price: $product->price()->value(),
            status: $product->status()->value(),
            visibility: $product->visibility()->value(),
            created_at: $product->createdAt(),
            updated_at: $product->updatedAt()
        );
    }
}