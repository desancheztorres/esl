<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Category\Infrastructure\Ui\Http\Controller;

use Arcmedia\Esl\Category\Application\Query\GetCategoriesHandler;
use Arcmedia\Esl\Category\Domain\Exception\CategoryStatusInvalid;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetCategoryController
{
    public function __construct(private readonly GetCategoriesHandler $getCategoriesHandler)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $categories = $this->getCategoriesHandler->__invoke();

            $response = new JsonResponse([
                'status' => 'ok',
                'hits' => [
                    $categories->toArray()
                ]
            ]);
        } catch (CategoryStatusInvalid $exception) {
            $response = new JsonResponse([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $response;
    }
}