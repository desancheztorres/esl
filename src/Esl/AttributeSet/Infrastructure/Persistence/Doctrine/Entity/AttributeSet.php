<?php

declare(strict_types=1);

namespace Arcmedia\Esl\AttributeSet\Infrastructure\Persistence\Doctrine\Entity;

use DateTime;
use DateTimeInterface;

final class AttributeSet
{
    public function __construct(
        private readonly string $id,
        private readonly string $name,
        private readonly DateTimeInterface $created_at,
        private readonly ?DateTime $updated_at,
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function created_at(): DateTimeInterface
    {
        return $this->created_at;
    }

    public function updated_at(): ?DateTime
    {
        return $this->updated_at;
    }

}