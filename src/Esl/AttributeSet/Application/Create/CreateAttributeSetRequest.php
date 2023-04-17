<?php

declare(strict_types=1);

namespace Arcmedia\Esl\AttributeSet\Application\Create;

final class CreateAttributeSetRequest
{
    public function __construct(
        private readonly string $name,
        private readonly array $attributes
    ) {
    }

    public function name(): string
    {
        return $this->name;
    }

    public function attributes(): array
    {
        return $this->attributes;
    }
}