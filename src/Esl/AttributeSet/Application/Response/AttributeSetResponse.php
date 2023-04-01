<?php

declare(strict_types=1);

namespace Arcmedia\Esl\AttributeSet\Application\Response;

use Arcmedia\Esl\AttributeSet\Domain\AttributeSet;

final class AttributeSetResponse
{
    private string $id;
    private string $name;

    public function __construct(readonly AttributeSet $attributeSet)
    {
        $this->id = $this->attributeSet->id()->value();
        $this->name = $this->attributeSet->name()->value();
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id(),
            'name' => $this->name()
        ];
    }
}