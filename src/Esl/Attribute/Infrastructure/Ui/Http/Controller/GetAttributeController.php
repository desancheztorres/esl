<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Attribute\Infrastructure\Ui\Http\Controller;

use Arcmedia\Esl\Attribute\Application\Query\GetAttributesHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetAttributeController
{
    public function __construct(private readonly GetAttributesHandler $handler)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $attributes = $this->handler->__invoke();

            $response = new JsonResponse([
                'status' => 'ok',
                'hits' => [
                    $attributes->toArray()
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