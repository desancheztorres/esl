<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Category\Application\Request;

final class CreateCategoryRequest
{
    public function __construct(
        private readonly string $name,
        private readonly string $parent,
        private readonly int $is_active,
        private readonly int $level,
        private readonly string $path,
    ) {
    }

    public function name(): string
    {
        return $this->name;
    }

    public function parent(): string
    {
        return $this->parent;
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
}