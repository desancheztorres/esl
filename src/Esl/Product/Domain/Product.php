<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Product\Domain;

use Arcmedia\Esl\Product\Domain\ValueObject\ProductId;
use Arcmedia\Esl\Product\Domain\ValueObject\ProductName;
use Arcmedia\Esl\Product\Domain\ValueObject\ProductPrice;
use Arcmedia\Esl\Product\Domain\ValueObject\ProductSku;
use Arcmedia\Esl\Product\Domain\ValueObject\ProductStatus;
use Arcmedia\Esl\Product\Domain\ValueObject\ProductVisibility;
use DateTime;
use DateTimeImmutable;

final class Product
{
    private DateTimeImmutable $created_at;
    private DateTime $updated_at;

    public function __construct(
        private readonly ProductId $id,
        private readonly ProductSku $sku,
        private readonly ProductName $name,
        private readonly ProductPrice $price,
        private readonly ProductStatus $status,
        private readonly ProductVisibility $visibility
    )
    {
        $this->created_at = new DateTimeImmutable();
        $this->updated_at = new DateTime();
    }

    public function id(): ProductId
    {
        return $this->id;
    }

    public function sku(): ProductSku
    {
        return $this->sku;
    }

    public function name(): ProductName
    {
        return $this->name;
    }

    public function price(): ProductPrice
    {
        return $this->price;
    }

    public function status(): ProductStatus
    {
        return $this->status;
    }

    public function visibility(): ProductVisibility
    {
        return $this->visibility;
    }

    public function createdAt(): DateTimeImmutable
    {
        return $this->created_at;
    }

    public function updatedAt(): DateTime
    {
        return $this->updated_at;
    }

    public static function create(
        ProductId $id,
        ProductSku $sku,
        ProductName $name,
        ProductPrice $price,
        ProductStatus $status,
        ProductVisibility $visibility
    ): self
    {
        return new self($id, $sku, $name, $price, $status, $visibility);
    }
}