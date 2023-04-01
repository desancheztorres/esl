<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Attribute\Application\Query;

use Arcmedia\Esl\Attribute\Application\Response\AttributeCollectionResponse;
use Arcmedia\Esl\Attribute\Domain\Contract\AttributeRepository;

final class GetAttributesHandler
{
    public function __construct(private readonly AttributeRepository $repository)
    {
    }

    public function __invoke(): AttributeCollectionResponse
    {
        $attributes = $this->repository->findAll();

        return new AttributeCollectionResponse($attributes);
    }
}