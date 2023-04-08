<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Product\Domain\Contract;

use Arcmedia\Esl\Product\Domain\Product;
use Arcmedia\Esl\Product\Domain\ProductCollection;

interface ProductRepository
{
    public function findAll(): ProductCollection;
    public function save(Product $product): void;
}