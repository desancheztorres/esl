<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Category\Application\Response;

use Arcmedia\Esl\Category\Domain\Category;

final class CategoryResponse
{
    private string $id;
    private string $name;
    private string $parent;
    private int $isActive;
    private int $level;
    private string $path;

    public function __construct(private readonly Category $category)
    {
        $this->id = $this->category->id()->value();
        $this->name = $this->category->name()->value();
        $this->parent = $this->category->parent()->value();
        $this->isActive = $this->category->isActive()->value();
        $this->level = $this->category->level()->value();
        $this->path = $this->category->path()->value();
    }

    public function id(): string
    {
        return $this->id;
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
        return $this->isActive;
    }

    public function level(): int
    {
        return $this->level;
    }

    public function path(): string
    {
        return $this->path;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id(),
            'name' => $this->name(),
            'parent' => $this->parent(),
            'isActive' => $this->isActive(),
            'level' => $this->level(),
            'path' => $this->path(),
        ];
    }
}