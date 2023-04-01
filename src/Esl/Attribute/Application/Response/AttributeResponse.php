<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Attribute\Application\Response;

use Arcmedia\Esl\Attribute\Domain\Attribute;

final class AttributeResponse
{
    private string $id;
    private string $name;
    private int $searchable;
    private int $filterable;
    private string $description;
    private string $backendModel;
    private string $frontendInput;
    private string $frontendModel;
    private string $sourceModel;

    public function __construct(readonly Attribute $attribute)
    {
        $this->id = $attribute->id()->value();
        $this->name = $attribute->name()->value();
        $this->searchable = $attribute->searchable()->value();
        $this->filterable = $attribute->filterable()->value();
        $this->description = $attribute->description()->value();
        $this->backendModel = $attribute->backendModel()->value();
        $this->frontendInput = $attribute->frontendInput()->value();
        $this->frontendModel = $attribute->frontendModel()->value();
        $this->sourceModel = $attribute->sourceModel()->value();
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function searchable(): int
    {
        return $this->searchable;
    }

    public function filterable(): int
    {
        return $this->filterable;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function backendModel(): string
    {
        return $this->backendModel;
    }

    public function frontendInput(): string
    {
        return $this->frontendInput;
    }

    public function frontendModel(): string
    {
        return $this->frontendModel;
    }

    public function sourceModel(): string
    {
        return $this->sourceModel;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id(),
            'name' => $this->name(),
            'searchable' => $this->searchable(),
            'filterable' => $this->filterable(),
            'description' => $this->description(),
            'backend_model' => $this->backendModel(),
            'frontend_input' => $this->frontendInput(),
            'frontend_model' => $this->frontendModel(),
            'source_model' => $this->sourceModel(),
        ];
    }
}