<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Category\Domain\Service;

interface IdStringGenerator
{
    public function generate(): string;
}