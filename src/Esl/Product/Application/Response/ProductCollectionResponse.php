<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Product\Application\Response;

use Arcmedia\Esl\Product\Domain\ProductCollection;

final class ProductCollectionResponse
{
    private array $products;

    public function __construct(ProductCollection $productCollection)
    {
        $this->products = [];

        foreach ($productCollection->getCollection() as $product) {
            $this->products[] = new ProductResponse($product);
        }
    }

    public function products(): array
    {
        return $this->products;
    }

    public function toArray(): array
    {
        return array_map(function ($product) {
            return $product->toArray();
        }, $this->products);
    }
}