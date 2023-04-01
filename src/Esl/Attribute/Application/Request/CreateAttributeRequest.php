<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Attribute\Application\Request;

final class CreateAttributeRequest
{
    public function __construct(
        private readonly string $code,
        private readonly string $name,
        private readonly string $searchable,
        private readonly string $filterable,
        private readonly string $description,
        private readonly string $backendType,
        private readonly string $backendModel,
        private readonly string $frontendInput,
        private readonly string $frontendModel,
        private readonly string $sourceModel
    )
    {
    }

    public function code(): string
    {
        return $this->code;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function searchable(): string
    {
        return $this->searchable;
    }

    public function filterable(): string
    {
        return $this->filterable;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function backendType(): string
    {
        return $this->backendType;
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
}