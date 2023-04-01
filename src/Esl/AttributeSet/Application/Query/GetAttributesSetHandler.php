<?php

declare(strict_types=1);

namespace Arcmedia\Esl\AttributeSet\Application\Query;

use Arcmedia\Esl\AttributeSet\Application\Response\AttributeSetCollectionResponse;
use Arcmedia\Esl\AttributeSet\Domain\Contract\AttributeSetRepository;

final class GetAttributesSetHandler
{
    public function __construct(private readonly AttributeSetRepository $repository)
    {
    }

    public function __invoke(): AttributeSetCollectionResponse
    {
        $attributesSet = $this->repository->findAll();

        return new AttributeSetCollectionResponse($attributesSet);
    }
}