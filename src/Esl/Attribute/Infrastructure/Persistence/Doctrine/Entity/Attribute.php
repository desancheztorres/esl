<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Attribute\Infrastructure\Persistence\Doctrine\Entity;

use DateTimeInterface;

final class Attribute
{
    public function __construct(
        private readonly string $id,
        private readonly string $code,
        private readonly string $name,
        private readonly bool $is_searchable,
        private readonly bool $is_filterable,
        private readonly string $description,
        private readonly string $backend_type,
        private readonly string $backend_model,
        private readonly string $frontend_input,
        private readonly string $frontend_model,
        private readonly string $source_model,
        private readonly DateTimeInterface $created_at,
        private readonly ?DateTimeInterface $updated_at,
    )
    {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function searchable(): bool
    {
        return $this->is_searchable;
    }

    public function filterable(): bool
    {
        return $this->is_filterable;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function backendType(): string
    {
        return $this->backend_type;
    }

    public function backendModel(): string
    {
        return $this->backend_model;
    }

    public function frontendInput(): string
    {
        return $this->frontend_input;
    }

    public function frontendModel(): string
    {
        return $this->frontend_model;
    }

    public function sourceModel(): string
    {
        return $this->source_model;
    }

    public function createdAt(): DateTimeInterface
    {
        return $this->created_at;
    }

    public function updatedAt(): DateTimeInterface
    {
        return $this->updated_at;
    }
}