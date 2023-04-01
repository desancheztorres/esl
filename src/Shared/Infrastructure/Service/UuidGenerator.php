<?php

declare(strict_types=1);

namespace Arcmedia\Shared\Infrastructure\Service;

use Arcmedia\Shared\Domain\Service\IdStringGenerator;
use Ramsey\Uuid\Uuid;

final class UuidGenerator implements IdStringGenerator
{
    public function generate(): string
    {
        return Uuid::uuid4()->toString();
    }
}