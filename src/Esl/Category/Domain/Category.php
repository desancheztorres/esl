<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Category\Domain;

use Arcmedia\Esl\Category\Domain\ValueObject\CategoryId;
use Arcmedia\Esl\Category\Domain\ValueObject\CategoryIsActive;
use Arcmedia\Esl\Category\Domain\ValueObject\CategoryLevel;
use Arcmedia\Esl\Category\Domain\ValueObject\CategoryName;
use Arcmedia\Esl\Category\Domain\ValueObject\CategoryParentId;
use Arcmedia\Esl\Category\Domain\ValueObject\CategoryPath;
use DateTime;
use DateTimeImmutable;

final class Category
{
    private DateTimeImmutable $createdAt;
    private DateTime $updatedAt;

    public function __construct(
        private readonly CategoryId $id,
        private readonly CategoryName $name,
        private readonly CategoryParentId $parent_id,
        private readonly CategoryIsActive $isActive,
        private readonly CategoryLevel $level,
        private readonly CategoryPath $path,
    )
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTime();
    }

    public function id(): CategoryId
    {
        return $this->id;
    }

    public function name(): CategoryName
    {
        return $this->name;
    }

    public function parent(): CategoryParentId
    {
        return $this->parent_id;
    }

    public function isActive(): CategoryIsActive
    {
        return $this->isActive;
    }

    public function level(): CategoryLevel
    {
        return $this->level;
    }

    public function path(): CategoryPath
    {
        return $this->path;
    }

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public static function create(
        CategoryId $id,
        CategoryName $name,
        CategoryParentId $parent_id,
        CategoryIsActive $isActive,
        CategoryLevel $level,
        CategoryPath $path,
    ): self
    {
        return new self($id, $name, $parent_id, $isActive, $level, $path);
    }
}