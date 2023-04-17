<?php

declare(strict_types=1);

namespace Arcmedia\Esl\AttributeSet\Infrastructure\Ui\Http\Controller;

use Arcmedia\Esl\AttributeSet\Application\Command\SaveAttributeSetHandler;
use Arcmedia\Esl\AttributeSet\Application\Create\CreateAttributeSetRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class SaveAttributeSetController
{
    public function __construct(private readonly SaveAttributeSetHandler $handler)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $attributeSet = $this->handler->__invoke(
                new CreateAttributeSetRequest(
                    name: $request->get('name', 'hahah'),
                    attributes: $request->get('attributes', []),
                )
            );

            $response = new JsonResponse([
                'status' => 'ok',
                'hits' => [
                    $attributeSet->toArray()
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