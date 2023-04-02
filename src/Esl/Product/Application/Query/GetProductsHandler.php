<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Product\Application\Query;

use Arcmedia\Esl\Product\Application\Response\ProductCollectionResponse;
use Arcmedia\Esl\Product\Domain\Contract\ProductRepository;

final class GetProductsHandler
{
    public function __construct(private readonly ProductRepository $repository)
    {
    }

    public function __invoke(): ProductCollectionResponse
    {
        $products = $this->repository->findAll();

        return new ProductCollectionResponse($products);
    }
}