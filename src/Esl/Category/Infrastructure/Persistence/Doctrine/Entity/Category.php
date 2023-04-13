<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Category\Infrastructure\Persistence\Doctrine\Entity;

use DateTimeInterface;

final class Category
{
    public function __construct(
        private readonly string $id,
        private readonly string $name,
        private readonly string $parent_id,
        private readonly int $is_active,
        private readonly int $level,
        private readonly string $path,
        private readonly DateTimeInterface $created_at,
        private readonly DateTimeInterface $updated_at,
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function parent_id(): string
    {
        return $this->parent_id;
    }

    public function isActive(): int
    {
        return $this->is_active;
    }

    public function level(): int
    {
        return $this->level;
    }

    public function path(): string
    {
        return $this->path;
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