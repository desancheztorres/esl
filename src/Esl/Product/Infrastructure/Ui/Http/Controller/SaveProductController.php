<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Product\Infrastructure\Ui\Http\Controller;

use Arcmedia\Esl\Product\Application\Command\SaveProductsHandler;
use Arcmedia\Esl\Product\Application\Request\CreateProductRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class SaveProductController
{
    public function __construct(private readonly SaveProductsHandler $saveProductsHandler)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $product = $this->saveProductsHandler->__invoke(
                new CreateProductRequest(
                    sku: $request->get('sku'),
                    name: $request->get('name'),
                    price: (int) $request->get('price'),
                    status: (int) $request->get('status'),
                    visibility: (int) $request->get('visibility')
                )
            );

            $response = new JsonResponse([
                'status' => 'ok',
                'hits' => [
                    $product->toArray()
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