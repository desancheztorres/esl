<?php

declare(strict_types=1);

namespace App\Category\Application;

use App\Category\Domain\Category;
use App\Category\Domain\ValueObject\CategoryErpId;
use App\Category\Domain\ValueObject\CategoryIsActive;
use App\Category\Domain\ValueObject\CategoryName;
use App\Category\Domain\ValueObject\CategoryParent;

final class CategoryCreator
{
    private static array $categories;

    public function __invoke(
        string $id,
        CategoryErpId $erpId,
        CategoryName $name,
        CategoryParent $parent,
        CategoryIsActive $isActive
    ): void {

        $category = new Category($id, $erpId, $name, $parent, $isActive);

        self::$categories[$id] = $category;
    }
}