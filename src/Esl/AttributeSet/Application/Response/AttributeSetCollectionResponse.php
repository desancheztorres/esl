<?php

declare(strict_types=1);

namespace Arcmedia\Esl\AttributeSet\Application\Response;

use Arcmedia\Esl\AttributeSet\Domain\AttributeSetCollection;

final class AttributeSetCollectionResponse
{
    private array $attributesSet;

    public function __construct(AttributeSetCollection $attributeCollection)
    {
        $this->attributesSet = [];

        foreach ($attributeCollection->getCollection() as $attributeSet) {
            $this->attributesSet[] = new AttributeSetResponse($attributeSet);
        }
    }

    public function attributesSet(): array
    {
        return $this->attributesSet;
    }

    public function toArray(): array
    {
        return array_map(function ($attributeSet) {
            return $attributeSet->toArray();
        }, $this->attributesSet);
    }
}