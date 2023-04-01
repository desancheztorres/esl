<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Attribute\Application\Response;

use Arcmedia\Esl\Attribute\Domain\AttributeCollection;

final class AttributeCollectionResponse
{
    private array $attributes;

    public function __construct(AttributeCollection $attributeCollection)
    {
        $this->attributes = [];

        foreach ($attributeCollection->getCollection() as $attribute) {
            $this->attributes[] = new AttributeResponse($attribute);
        }
    }

    public function attributes(): array
    {
        return $this->attributes;
    }

    public function toArray(): array
    {
        return array_map(function ($attribute) {
            return $attribute->toArray();
        }, $this->attributes);
    }
}