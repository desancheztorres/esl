<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Attribute\Application\Command;

use Arcmedia\Esl\Attribute\Application\Request\CreateAttributeRequest;
use Arcmedia\Esl\Attribute\Application\Response\AttributeResponse;
use Arcmedia\Esl\Attribute\Domain\Attribute;
use Arcmedia\Esl\Attribute\Domain\Contract\AttributeRepository;
use Arcmedia\Esl\Attribute\Domain\Exception\AttributeAlreadyExists;
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
    ) {
    }

    public function __invoke(CreateAttributeRequest $request): AttributeResponse
    {
        $attribute = Attribute::create(
            id: new AttributeId($this->idStringGenerator->generate()),
            code: new AttributeCode($request->code()),
            name: new AttributeName($request->name()),
            searchable: new AttributeSearchable($request->searchable()),
            filterable: new AttributeFilterable($request->filterable()),
            description: new AttributeDescription($request->description()),
            backendType: new AttributeBackendType($request->backendType()),
            backendModel: new AttributeBackendModel($request->backendModel()),
            frontendInput: new AttributeFrontendInput($request->frontendInput()),
            frontendModel: new AttributeFrontendModel($request->frontendModel()),
            sourceModel: new AttributeSourceModel($request->sourceModel())
        );

        $this->ensureAttributeDoesntExist($request->code());

        $this->repository->save($attribute);

        return new AttributeResponse($attribute);
    }

    private function ensureAttributeDoesntExist(string $code): void
    {
        $attributeCode = new AttributeCode($code);
        $existingAttribute = $this->repository->search($attributeCode);

        if (null !== $existingAttribute) {
            throw new AttributeAlreadyExists("Attribute code {$attributeCode->value()} already exists in database.");
        }
    }
}
