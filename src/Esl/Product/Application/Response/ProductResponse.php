<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Product\Application\Response;

use Arcmedia\Esl\Product\Domain\Product;

final class ProductResponse
{
    private string $id;
    private string $sku;
    private string $name;
    private int $price;
    private int $status;
    private int $visibility;

    public function __construct(readonly Product $product)
    {
        $this->id = $product->id()->value();
        $this->sku = $product->sku()->value();
        $this->name = $product->name()->value();
        $this->price = $product->price()->value();
        $this->status = $product->status()->value();
        $this->visibility = $product->visibility()->value();
    }

    public function id(): string
    {
        return $this->id;
    }

    public function sku(): string
    {
        return $this->sku;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function price(): int
    {
        return $this->price;
    }

    public function status(): int
    {
        return $this->status;
    }

    public function visibility(): int
    {
        return $this->visibility;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'sku' => $this->sku,
            'name' => $this->name,
            'price' => $this->price,
            'status' => $this->status,
            'visibility' => $this->visibility,
        ];
    }
}