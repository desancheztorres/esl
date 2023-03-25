<?php

declare(strict_types=1);

namespace App\Category\Infrastructure;

use App\Category\Application\CategoryCreator;
use App\Category\Domain\ValueObject\CategoryErpId;
use App\Category\Domain\ValueObject\CategoryId;
use App\Category\Domain\ValueObject\CategoryIsActive;
use App\Category\Domain\ValueObject\CategoryName;
use App\Category\Domain\ValueObject\CategoryParent;
use App\Category\Infrastructure\Repositories\DoctrineCategoryRepository;
use Ramsey\Uuid\Uuid;

final class CategoryPutController
{
    public function __construct(private readonly DoctrineCategoryRepository $categoryRepository)
    {
    }

    public function __invoke(string $categoryErpId, string $categoryName, string $categoryParent, bool $categoryIsActive): void
    {
        $id = new CategoryId(Uuid::uuid4()->toString());
        $erpId = new CategoryErpId($categoryErpId);
        $name = new CategoryName($categoryName);
        $parent = new CategoryParent($categoryParent);
        $isActive = new CategoryIsActive($categoryIsActive);

        $categoryCreator = new CategoryCreator($this->categoryRepository);
        $categoryCreator($id, $erpId, $name, $parent, $isActive);
    }
}