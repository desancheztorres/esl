<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Category\Infrastructure\Service;

use Arcmedia\Esl\Category\Domain\Service\IdStringGenerator;
use Ramsey\Uuid\Uuid;

final class UuidGenerator implements IdStringGenerator
{
    public function generate(): string
    {
        return Uuid::uuid4()->toString();
    }
}