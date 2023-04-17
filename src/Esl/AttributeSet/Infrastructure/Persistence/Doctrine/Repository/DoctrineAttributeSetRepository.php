<?php

declare(strict_types=1);

namespace Arcmedia\Esl\AttributeSet\Infrastructure\Persistence\Doctrine\Repository;

use Arcmedia\Esl\AttributeSet\Domain\AttributeSet;
use Arcmedia\Esl\AttributeSet\Domain\AttributeSetCollection;
use Arcmedia\Esl\AttributeSet\Domain\Contract\AttributeSetRepository;
use Arcmedia\Esl\AttributeSet\Domain\ValueObject\AttributeSetId;
use Arcmedia\Esl\AttributeSet\Domain\ValueObject\AttributeSetName;
use Arcmedia\Esl\AttributeSet\Infrastructure\Persistence\Doctrine\Entity\AttributeSet as AttributeSetEntity;
use Arcmedia\Shared\Infrastructure\Persistence\Doctrine\Repository\DoctrineRepository;
use Doctrine\ORM\Exception\ORMException;

final class DoctrineAttributeSetRepository extends DoctrineRepository implements AttributeSetRepository
{
    protected function entityClassName(): string
    {
        return AttributeSetEntity::class;
    }

    public function findAll(): AttributeSetCollection
    {
        $attributesSet = $this->repository->findAll();

        $attributeSetCollection = AttributeSetCollection::init();

        if (!empty($attributesSet)) {
            foreach ($attributesSet as $attributeSet) {
                $attributeSetCollection->add($this->toDomain($attributeSet));
            }
        }

        return $attributeSetCollection;
    }

    public function searchByCriteria(AttributeSetName $name): ?AttributeSet
    {
        $attributeSet = $this->repository->findOneBy(['name' => $name->value()]);

        if (null === $attributeSet) {
            return null;
        }

        return $this->toDomain($attributeSet);
    }

    public function save(AttributeSet $attributeSet): void
    {
        try {
            $this->entityManager->persist($this->toEntity($attributeSet));
            $this->entityManager->flush();
        } catch (ORMException $e) {
            var_dump($e->getMessage());
        }
    }

    private function toDomain(AttributeSetEntity $attributeSet): AttributeSet
    {
        return new AttributeSet(
            id: new AttributeSetId($attributeSet->id()),
            name: new AttributeSetName($attributeSet->name()),
        );
    }

    private function toEntity(AttributeSet $attributeSet): AttributeSetEntity
    {
        return new AttributeSetEntity(
            id: $attributeSet->id()->value(),
            name: $attributeSet->name()->value(),
            created_at: $attributeSet->created_at(),
            updated_at: $attributeSet->updated_at()
        );
    }
}
