<?php

declare(strict_types=1);

namespace App\Category\Domain;

use App\Category\Domain\ValueObject\CategoryErpId;
use App\Category\Domain\ValueObject\CategoryId;
use App\Category\Domain\ValueObject\CategoryIsActive;
use App\Category\Domain\ValueObject\CategoryName;
use App\Category\Domain\ValueObject\CategoryParent;
use App\Category\Shared\Domain\ValueObject\UuidValueObject;

final class Category
{
    public function __construct(
        private CategoryId $id,
        private CategoryErpId $erpId,
        private CategoryName $name,
        private CategoryParent $parent,
        private CategoryIsActive $isActive
    )
    {
    }

    public function id(): UuidValueObject
    {
        return $this->id;
    }

    public function erpId(): CategoryErpId
    {
        return $this->erpId;
    }

    public function name(): CategoryName
    {
        return $this->name;
    }

    public function parent(): CategoryParent
    {
        return $this->parent;
    }

    public function isActive(): CategoryIsActive
    {
        return $this->isActive;
    }
}