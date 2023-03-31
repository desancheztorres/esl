<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Category\Domain;

use Arcmedia\Esl\Category\Domain\ValueObject\CategoryId;
use Arcmedia\Esl\Category\Domain\ValueObject\CategoryIsActive;
use Arcmedia\Esl\Category\Domain\ValueObject\CategoryLevel;
use Arcmedia\Esl\Category\Domain\ValueObject\CategoryName;
use Arcmedia\Esl\Category\Domain\ValueObject\CategoryParent;
use DateTime;
use DateTimeImmutable;

final class Category
{
    private DateTimeImmutable $createdAt;
    private DateTime $updatedAt;

    public function __construct(
        private readonly CategoryId $id,
        private readonly CategoryName $name,
        private readonly CategoryParent $parent,
        private readonly CategoryIsActive $isActive,
        private readonly CategoryLevel $level
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

    public function parent(): CategoryParent
    {
        return $this->parent;
    }

    public function isActive(): CategoryIsActive
    {
        return $this->isActive;
    }

    public function level(): CategoryLevel
    {
        return $this->level;
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
        CategoryParent $parent,
        CategoryIsActive $isActive,
        CategoryLevel $level
    ): self
    {
        return new self($id, $name, $parent, $isActive, $level);
    }
}