<?php

declare(strict_types=1);

namespace App\Category\Domain\Contracts;

use App\Category\Domain\Category;

interface CategoryRepository
{
    public function save(Category $category): void;

    /**
     * @param Category[] $categories
     */
    public function saveMany(array $categories): void;
}