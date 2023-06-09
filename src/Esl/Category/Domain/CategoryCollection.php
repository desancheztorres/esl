<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Category\Domain;

use Arcmedia\Shared\Domain\Collection\ObjectCollection;

final class CategoryCollection extends ObjectCollection
{
    protected function className(): string
    {
        return Category::class;
    }
}