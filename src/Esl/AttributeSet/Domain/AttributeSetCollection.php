<?php

declare(strict_types=1);

namespace Arcmedia\Esl\AttributeSet\Domain;

use Arcmedia\Shared\Domain\Collection\ObjectCollection;

final class AttributeSetCollection extends ObjectCollection
{
    protected function className(): string
    {
        return AttributeSet::class;
    }
}