<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Category\Domain\Contract;

use Arcmedia\Esl\Category\Domain\Category;
use Arcmedia\Esl\Category\Domain\CategoryCollection;

interface CategoryRepository
{
    public function findAll(): CategoryCollection;
    public function save(Category $category): void;
}