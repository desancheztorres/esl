<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Product\Application\Command;

use Arcmedia\Esl\Product\Application\Request\CreateProductRequest;
use Arcmedia\Esl\Product\Application\Response\ProductResponse;
use Arcmedia\Esl\Product\Domain\Contract\ProductRepository;
use Arcmedia\Esl\Product\Domain\Product;
use Arcmedia\Esl\Product\Domain\ValueObject\ProductId;
use Arcmedia\Esl\Product\Domain\ValueObject\ProductName;
use Arcmedia\Esl\Product\Domain\ValueObject\ProductPrice;
use Arcmedia\Esl\Product\Domain\ValueObject\ProductSku;
use Arcmedia\Esl\Product\Domain\ValueObject\ProductStatus;
use Arcmedia\Esl\Product\Domain\ValueObject\ProductVisibility;
use Arcmedia\Shared\Domain\Service\IdStringGenerator;

final class SaveProductsHandler
{
    public function __construct(
        private readonly ProductRepository $repository,
        private readonly IdStringGenerator $idStringGenerator,
    )
    {
    }

    public function __invoke(CreateProductRequest $request): ProductResponse
    {
        $product = Product::create(
            id: new ProductId($this->idStringGenerator->generate()),
            sku: new ProductSku($request->sku()),
            name: new ProductName($request->name()),
            price: new ProductPrice($request->price()),
            status: new ProductStatus($request->status()),
            visibility: new ProductVisibility($request->visibility())
        );

        $this->repository->save($product);

        return new ProductResponse($product);
    }
}