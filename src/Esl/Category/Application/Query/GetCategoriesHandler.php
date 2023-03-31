<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Category\Application\Query;

use Arcmedia\Esl\Category\Application\Response\CategoryCollectionResponse;
use Arcmedia\Esl\Category\Domain\Contract\CategoryRepository;

final class GetCategoriesHandler
{
    public function __construct(private readonly CategoryRepository $categoryRepository)
    {
    }

    public function __invoke(): CategoryCollectionResponse
    {
        $categories = $this->categoryRepository->findAll();

        return new CategoryCollectionResponse($categories);
    }
}