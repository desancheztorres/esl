<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Category\Infrastructure\Ui\Http\Controller;

use Arcmedia\Esl\Category\Application\Command\SaveCategoriesHandler;
use Arcmedia\Esl\Category\Application\Request\CreateCategoryRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class SaveCategoryController
{
    public function __construct(private readonly SaveCategoriesHandler $saveCategoriesHandler)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $category = $this->saveCategoriesHandler->__invoke(
                new CreateCategoryRequest(
                    name: $request->get('name'),
                    parent: $request->get('parent'),
                    is_active: (int) $request->get('is_active'),
                    level: (int) $request->get('level')
                )
            );

            $response = new JsonResponse([
                'status' => 'ok',
                'hits' => [
                    $category->toArray()
                ]
            ]);
        } catch (\Exception $exception) {
            $response = new JsonResponse([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $response;
    }
}