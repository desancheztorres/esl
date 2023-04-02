<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Product\Domain;

use Arcmedia\Shared\Domain\Collection\ObjectCollection;

final class ProductCollection extends ObjectCollection
{

    protected function className(): string
    {
        return Product::class;
    }
}