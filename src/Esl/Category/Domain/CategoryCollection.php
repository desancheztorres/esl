<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Category\Domain;

use Arcmedia\Esl\Category\Domain\Collection\ObjectCollection;

final class CategoryCollection extends ObjectCollection
{

    protected function className(): string
    {
        return Category::class;
    }
}