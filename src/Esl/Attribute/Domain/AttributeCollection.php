<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Attribute\Domain;

use Arcmedia\Shared\Domain\Collection\ObjectCollection;

final class AttributeCollection extends ObjectCollection
{
    protected function className(): string
    {
        return Attribute::class;
    }
}