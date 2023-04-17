<?php

declare(strict_types=1);

namespace Arcmedia\Esl\AttributeSet\Application\Command;

use Arcmedia\Esl\AttributeSet\Application\Create\CreateAttributeSetRequest;
use Arcmedia\Esl\AttributeSet\Application\Response\AttributeSetResponse;
use Arcmedia\Esl\AttributeSet\Domain\AttributeSet;
use Arcmedia\Esl\AttributeSet\Domain\Contract\AttributeSetRepository;
use Arcmedia\Esl\AttributeSet\Domain\Exception\AttributeSetAlreadyExists;
use Arcmedia\Esl\AttributeSet\Domain\ValueObject\AttributeSetId;
use Arcmedia\Esl\AttributeSet\Domain\ValueObject\AttributeSetName;
use Arcmedia\Shared\Domain\Service\IdStringGenerator;

final class SaveAttributeSetHandler
{
    public function __construct(
        private readonly AttributeSetRepository $repository,
        private readonly IdStringGenerator $idStringGenerator
    ) {
    }

    public function __invoke(CreateAttributeSetRequest $request): AttributeSetResponse
    {
        $attributeSet = AttributeSet::create(
            id: new AttributeSetId($this->idStringGenerator->generate()),
            name: new AttributeSetName($request->name())
        );

        $this->ensureAttributeSetDoesntExist($request->name());

        $this->repository->save($attributeSet);

        return new AttributeSetResponse($attributeSet);
    }

    private function ensureAttributeSetDoesntExist(string $name): void
    {
        $attributSetName = new AttributeSetName($name);
        $existingAttributeSet = $this->repository->searchByCriteria($attributSetName);

        if (null !== $existingAttributeSet) {
            throw new AttributeSetAlreadyExists("Attribute set name with value `$name` already exists in database.");
        }
    }
}
