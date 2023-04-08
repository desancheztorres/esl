<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Product\Infrastructure\Ui\Http\Controller;

use Arcmedia\Esl\Product\Application\Query\GetProductsHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetProductController
{
    public function __construct(private readonly GetProductsHandler $getProductsHandler)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $products = $this->getProductsHandler->__invoke();

            $response = new JsonResponse([
                'status' => 'ok',
                'hits' => [
                    $products->toArray()
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