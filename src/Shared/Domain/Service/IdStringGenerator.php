<?php

declare(strict_types=1);

namespace Arcmedia\Shared\Domain\Service;

interface IdStringGenerator
{
    public function generate(): string;
}