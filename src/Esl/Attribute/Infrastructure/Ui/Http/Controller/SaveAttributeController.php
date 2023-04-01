<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Attribute\Infrastructure\Ui\Http\Controller;

use Arcmedia\Esl\Attribute\Application\Command\SaveAttributesHandler;
use Arcmedia\Esl\Attribute\Application\Request\CreateAttributeRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class SaveAttributeController
{
    public function __construct(private readonly SaveAttributesHandler $saveAttributesHandler)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $attribute = $this->saveAttributesHandler->__invoke(
                new CreateAttributeRequest(
                    code: $request->get('code'),
                    name: $request->get('name'),
                    searchable: $request->get('searchable'),
                    filterable: $request->get('filterable'),
                    description: $request->get('description'),
                    backendType: $request->get('backend_type'),
                    backendModel: $request->get('backend_model'),
                    frontendInput: $request->get('frontend_input'),
                    frontendModel: $request->get('frontend_model'),
                    sourceModel: $request->get('source_model'),
                )
            );

            $response = new JsonResponse([
                'status' => 'ok',
                'hits' => [
                    $attribute->toArray()
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