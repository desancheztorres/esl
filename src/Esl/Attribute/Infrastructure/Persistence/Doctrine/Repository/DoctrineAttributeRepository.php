<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Attribute\Infrastructure\Persistence\Doctrine\Repository;

use Arcmedia\Esl\Attribute\Domain\Attribute;
use Arcmedia\Esl\Attribute\Domain\AttributeCollection;
use Arcmedia\Esl\Attribute\Domain\Contract\AttributeRepository;
use Arcmedia\Esl\Attribute\Domain\ValueObject\AttributeBackendModel;
use Arcmedia\Esl\Attribute\Domain\ValueObject\AttributeBackendType;
use Arcmedia\Esl\Attribute\Domain\ValueObject\AttributeCode;
use Arcmedia\Esl\Attribute\Domain\ValueObject\AttributeDescription;
use Arcmedia\Esl\Attribute\Domain\ValueObject\AttributeFilterable;
use Arcmedia\Esl\Attribute\Domain\ValueObject\AttributeFrontendInput;
use Arcmedia\Esl\Attribute\Domain\ValueObject\AttributeFrontendModel;
use Arcmedia\Esl\Attribute\Domain\ValueObject\AttributeId;
use Arcmedia\Esl\Attribute\Domain\ValueObject\AttributeName;
use Arcmedia\Esl\Attribute\Domain\ValueObject\AttributeSearchable;
use Arcmedia\Esl\Attribute\Domain\ValueObject\AttributeSourceModel;
use Arcmedia\Esl\Attribute\Infrastructure\Persistence\Doctrine\Entity\Attribute as AttributeEntity;
use Arcmedia\Shared\Domain\Collection\InvalidCollectionObjectException;
use Arcmedia\Shared\Infrastructure\Persistence\Doctrine\Repository\DoctrineRepository;
use Doctrine\ORM\Exception\ORMException;

final class DoctrineAttributeRepository extends DoctrineRepository implements AttributeRepository
{
    protected function entityClassName(): string
    {
        return AttributeEntity::class;
    }

    /**
     * @throws InvalidCollectionObjectException
     */
    public function findAll(): AttributeCollection
    {
        $attributes = $this->repository->findAll();

        $attributeCollection = AttributeCollection::init();

        if (!empty($attributes)) {
            foreach ($attributes as $attribute) {
                $attributeCollection->add($this->toDomain($attribute));
            }
        }

        return $attributeCollection;
    }

    public function search(AttributeCode $code): ?Attribute
    {
        $attribute = $this->repository->findOneBy(['code' => $code->value()]);

        if (null === $attribute) {
            return null;
        }

        return $this->toDomain($attribute);
    }

    public function save(Attribute $attribute): void
    {
        try {
            $this->entityManager->persist($this->toEntity($attribute));
            $this->entityManager->flush();
        } catch (ORMException $e) {
            var_dump($e->getMessage());
        }
    }

    private function toDomain(AttributeEntity $attribute): Attribute
    {
        $code = $attribute->code();

        return new Attribute(
            id: new AttributeId($attribute->id()),
            code: new AttributeCode($code),
            name: new AttributeName($attribute->name()),
            searchable: new AttributeSearchable($attribute->searchable()),
            filterable: new AttributeFilterable($attribute->filterable()),
            description: new AttributeDescription($attribute->description()),
            backendType: new AttributeBackendType($attribute->backendType()),
            backendModel: new AttributeBackendModel($attribute->backendModel()),
            frontendInput: new AttributeFrontendInput($attribute->frontendInput()),
            frontendModel: new AttributeFrontendModel($attribute->sourceModel()),
            sourceModel: new AttributeSourceModel($attribute->sourceModel())
        );
    }

    private function toEntity(Attribute $attribute): AttributeEntity
    {
        return new AttributeEntity(
            id: $attribute->id()->value(),
            code: $attribute->code()->value(),
            name: $attribute->name()->value(),
            is_searchable: $attribute->searchable()->value(),
            is_filterable: $attribute->filterable()->value(),
            description: $attribute->description()->value(),
            backend_type: $attribute->backendType()->value(),
            backend_model: $attribute->backendModel()->value(),
            frontend_input: $attribute->frontendInput()->value(),
            frontend_model: $attribute->sourceModel()->value(),
            source_model: $attribute->sourceModel()->value(),
            created_at: $attribute->createdAt(),
            updated_at: $attribute->updatedAt()
        );
    }
}