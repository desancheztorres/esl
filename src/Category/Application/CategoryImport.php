<?php

declare(strict_types=1);

namespace App\Category\Application;

use App\Category\Domain\Category;
use App\Category\Domain\Contracts\CategoryRepository;

final class CategoryImport
{
    public function __construct(private readonly CategoryRepository $categoryRepository)
    {
    }

    /**
     * @param Category[] $categories
     */
    public function __invoke(array $categories): void {

        $this->categoryRepository->saveMany($categories);
    }
}