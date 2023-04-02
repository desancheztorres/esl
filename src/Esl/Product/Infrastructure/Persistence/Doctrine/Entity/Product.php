<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Product\Infrastructure\Persistence\Doctrine\Entity;

use DateTimeInterface;

final class Product
{
    public function __construct(
        private readonly string $id,
        private readonly string $sku,
        private readonly string $name,
        private readonly int $price,
        private readonly int $status,
        private readonly int $visibility,
        private readonly DateTimeInterface $created_at,
        private readonly ?DateTimeInterface $updated_at
    )
    {
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

    public function created_at(): DateTimeInterface
    {
        return $this->created_at;
    }

    public function updated_at(): ?DateTimeInterface
    {
        return $this->updated_at;
    }

}