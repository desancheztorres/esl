<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Category\Application\Request;

final class GetCategoriesRequest
{
    public function __construct(private readonly string $status)
    {
    }

    public function status(): string
    {
        return $this->status;
    }
}