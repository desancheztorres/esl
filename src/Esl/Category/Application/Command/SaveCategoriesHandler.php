<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Category\Application\Command;

use Arcmedia\Esl\Category\Application\Request\CreateCategoryRequest;
use Arcmedia\Esl\Category\Application\Response\CategoryResponse;
use Arcmedia\Esl\Category\Domain\Category;
use Arcmedia\Esl\Category\Domain\Contract\CategoryRepository;
use Arcmedia\Esl\Category\Domain\ValueObject\CategoryId;
use Arcmedia\Esl\Category\Domain\ValueObject\CategoryIsActive;
use Arcmedia\Esl\Category\Domain\ValueObject\CategoryLevel;
use Arcmedia\Esl\Category\Domain\ValueObject\CategoryName;
use Arcmedia\Esl\Category\Domain\ValueObject\CategoryParent;
use Arcmedia\Shared\Domain\Service\IdStringGenerator;

final class SaveCategoriesHandler
{
    public function __construct(
        private readonly CategoryRepository $repository,
        private readonly IdStringGenerator $idStringGenerator
    )
    {
    }

    public function __invoke(CreateCategoryRequest $request): CategoryResponse
    {
        $category = Category::create(
            id: new CategoryId($this->idStringGenerator->generate()),
            name: new CategoryName($request->name()),
            parent: new CategoryParent($request->parent()),
            isActive: new CategoryIsActive($request->isActive()),
            level: new CategoryLevel($request->level())
        );

        $this->repository->save($category);

        return new CategoryResponse($category);
    }
}