<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Product\Application\Request;

final class CreateProductRequest
{
    public function __construct(
        private readonly string $sku,
        private readonly string $name,
        private readonly int $price,
        private readonly int $status,
        private readonly int $visibility
    )
    {
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

}