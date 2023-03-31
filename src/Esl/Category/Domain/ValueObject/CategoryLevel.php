<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Category\Domain\ValueObject;

final class CategoryLevel
{
    private int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function value(): int
    {
        return $this->value;
    }
}