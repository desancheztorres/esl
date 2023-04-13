<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Category\Application\Command;

use Arcmedia\Esl\Category\Domain\Category;
use Arcmedia\Esl\Category\Domain\Contract\CategoryRepository;
use Arcmedia\Esl\Category\Domain\ValueObject\CategoryId;
use Arcmedia\Esl\Category\Domain\ValueObject\CategoryIsActive;
use Arcmedia\Esl\Category\Domain\ValueObject\CategoryLevel;
use Arcmedia\Esl\Category\Domain\ValueObject\CategoryName;
use Arcmedia\Esl\Category\Domain\ValueObject\CategoryParentId;
use Arcmedia\Esl\Category\Domain\ValueObject\CategoryPath;
use Arcmedia\Shared\Domain\Service\IdStringGenerator;

final class SaveManyCategoriesHandler
{
    private array $categories = [];

    public function __construct(
        private readonly CategoryRepository $repository,
        private readonly IdStringGenerator $idStringGenerator,
    )
    {
    }

    public function __invoke(array $arrCategories): void
    {
        $this->generateId($arrCategories);
        $categories = [];

        foreach ($this->categories as $category) {
            $categories[] = Category::create(
                id: new CategoryId($category['id']),
                name: new CategoryName($category['name']),
                parent_id: new CategoryParentId($this->generateParentId($category['parent_path'])),
                isActive: new CategoryIsActive(1),
                level: new CategoryLevel(1),
                path: new CategoryPath($category['path'])
            );
        }

        $this->repository->saveMany($categories);
    }

    private function generateId(array $arrCategories): void
    {
        foreach ($arrCategories as &$category) {
            $category['id'] = $this->idStringGenerator->generate();
        }

        $this->categories = $arrCategories;
    }

    private function generateParentId($parent_path) {

        foreach ($this->categories as $category) {
            if ($category['path'] === $parent_path) {
                return $category['id'];
            }
        }

        return '';
    }
}