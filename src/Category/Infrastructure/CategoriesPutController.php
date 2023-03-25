<?php

declare(strict_types=1);

namespace App\Category\Infrastructure;

use App\Category\Application\CategoryImport;
use App\Category\Domain\Category;
use App\Category\Domain\ValueObject\CategoryErpId;
use App\Category\Domain\ValueObject\CategoryId;
use App\Category\Domain\ValueObject\CategoryIsActive;
use App\Category\Domain\ValueObject\CategoryName;
use App\Category\Domain\ValueObject\CategoryParent;
use App\Category\Infrastructure\Repositories\DoctrineCategoryRepository;
use Ramsey\Uuid\Uuid;

final class CategoriesPutController
{
    public function __construct(private readonly DoctrineCategoryRepository $categoryRepository)
    {
    }

    public function __invoke(array $categories): void
    {
        $arrCategories = [];
        foreach ($categories as $category) {
            $arrCategories[] = new Category(
                new CategoryId(Uuid::uuid4()->toString()),
                new CategoryErpId($category['category_id']),
                new CategoryName($category['category_name']),
                new CategoryParent($category['category_parent']),
                new CategoryIsActive((bool) $category['category_is_active'])
            );
        }

        $categoryCreator = new CategoryImport($this->categoryRepository);
        $categoryCreator($arrCategories);
    }
}