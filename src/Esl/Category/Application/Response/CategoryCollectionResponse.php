<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Category\Application\Response;

use Arcmedia\Esl\Category\Domain\CategoryCollection;

final class CategoryCollectionResponse
{
    private array $categories;

    public function __construct(CategoryCollection $categoryCollection)
    {
        $this->categories = [];

        foreach ($categoryCollection->getCollection() as $category) {
            $this->categories[] = new CategoryResponse($category);
        }
    }

    public function categories(): array
    {
        return $this->categories;
    }

    public function toArray(): array
    {
        return array_map(function ($category) {
            return $category->toArray();
        }, $this->categories);
    }
}