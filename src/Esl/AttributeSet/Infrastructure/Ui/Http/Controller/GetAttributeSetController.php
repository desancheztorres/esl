<?php

declare(strict_types=1);

namespace Arcmedia\Esl\AttributeSet\Infrastructure\Ui\Http\Controller;

use Arcmedia\Esl\AttributeSet\Application\Query\GetAttributesSetHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetAttributeSetController
{
    public function __construct(private readonly GetAttributesSetHandler $getAttributesSetHandler)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $attributesSet = $this->getAttributesSetHandler->__invoke();

            $response = new JsonResponse([
                'status' => 'ok',
                'hits' => [
                    $attributesSet->toArray()
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