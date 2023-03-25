<?php

declare(strict_types=1);

namespace App\Category\Application;

use App\Category\Domain\Category;
use App\Category\Domain\Contracts\CategoryRepository;
use App\Category\Domain\ValueObject\CategoryErpId;
use App\Category\Domain\ValueObject\CategoryId;
use App\Category\Domain\ValueObject\CategoryIsActive;
use App\Category\Domain\ValueObject\CategoryName;
use App\Category\Domain\ValueObject\CategoryParent;

final class CategoryCreator
{
    public function __construct(private readonly CategoryRepository $categoryRepository)
    {
    }

    public function __invoke(
        CategoryId $id,
        CategoryErpId $erpId,
        CategoryName $name,
        CategoryParent $parent,
        CategoryIsActive $isActive
    ): void {

        $category = new Category($id, $erpId, $name, $parent, $isActive);

        $this->categoryRepository->save($category);
    }
}