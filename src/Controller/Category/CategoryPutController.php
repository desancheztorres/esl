<?php

declare(strict_types=1);

namespace App\Controller\Category;

use App\Category\Application\CategoryCreator;
use App\Category\Domain\ValueObject\CategoryErpId;
use App\Category\Domain\ValueObject\CategoryIsActive;
use App\Category\Domain\ValueObject\CategoryName;
use App\Category\Domain\ValueObject\CategoryParent;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class CategoryPutController
{
    public function __construct(private readonly CategoryCreator $categoryCreator)
    {
    }

    public function __invoke(string $id, Request $request): Response
    {
        $this->categoryCreator->__invoke(
            Uuid::uuid4()->toString(),
            new CategoryErpId($request->get('erp_id')),
            new CategoryName($request->get('name')),
            new CategoryParent($request->get('parent')),
            new CategoryIsActive($request->get('is_active')),
        );

        return new Response('', Response::HTTP_CREATED);
    }
}