<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Attribute\Application\Command;

use Arcmedia\Esl\Attribute\Application\Request\CreateAttributeRequest;
use Arcmedia\Esl\Attribute\Application\Response\AttributeResponse;
use Arcmedia\Esl\Attribute\Domain\Attribute;
use Arcmedia\Esl\Attribute\Domain\Contract\AttributeRepository;
use Arcmedia\Esl\Attribute\Domain\ValueObject\AttributeBackendModel;
use Arcmedia\Esl\Attribute\Domain\ValueObject\AttributeBackendType;
use Arcmedia\Esl\Attribute\Domain\ValueObject\AttributeCode;
use Arcmedia\Esl\Attribute\Domain\ValueObject\AttributeDescription;
use Arcmedia\Esl\Attribute\Domain\ValueObject\AttributeFilterable;
use Arcmedia\Esl\Attribute\Domain\ValueObject\AttributeFrontendInput;
use Arcmedia\Esl\Attribute\Domain\ValueObject\AttributeFrontendModel;
use Arcmedia\Esl\Attribute\Domain\ValueObject\AttributeId;
use Arcmedia\Esl\Attribute\Domain\ValueObject\AttributeName;
use Arcmedia\Esl\Attribute\Domain\ValueObject\AttributeSearchable;
use Arcmedia\Esl\Attribute\Domain\ValueObject\AttributeSourceModel;
use Arcmedia\Shared\Domain\Service\IdStringGenerator;

final class SaveAttributesHandler
{
    public function __construct(
        private readonly AttributeRepository $repository,
        private readonly IdStringGenerator $idStringGenerator
    )
    {
    }

    public function __invoke(CreateAttributeRequest $request): AttributeResponse
    {
        $code = $request->code();

        $attribute = Attribute::create(
            id: new AttributeId($this->idStringGenerator->generate()),
            code: new AttributeCode($code),
            name: new AttributeName($code, $request->name()),
            searchable: new AttributeSearchable((int) $request->searchable()),
            filterable: new AttributeFilterable((int) $request->filterable()),
            description: new AttributeDescription($request->description()),
            backendType: new AttributeBackendType($request->backendType()),
            backendModel: new AttributeBackendModel($request->backendModel()),
            frontendInput: new AttributeFrontendInput($request->frontendInput()),
            frontendModel: new AttributeFrontendModel($request->frontendModel()),
            sourceModel: new AttributeSourceModel($request->sourceModel())
        );

        $this->repository->save($attribute);

        return new AttributeResponse($attribute);
    }
}