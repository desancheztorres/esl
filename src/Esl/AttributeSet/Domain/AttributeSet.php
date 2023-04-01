<?php

declare(strict_types=1);

namespace Arcmedia\Esl\AttributeSet\Domain;

use Arcmedia\Esl\AttributeSet\Domain\ValueObject\AttributeSetId;
use Arcmedia\Esl\AttributeSet\Domain\ValueObject\AttributeSetName;
use DateTime;
use DateTimeImmutable;

final class AttributeSet
{
    private DateTimeImmutable $createdAt;
    private DateTime $updatedAt;

    public function __construct(
        private readonly AttributeSetId $id,
        private readonly AttributeSetName $name
    )
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTime();
    }

    public function id(): AttributeSetId
    {
        return $this->id;
    }

    public function name(): AttributeSetName
    {
        return $this->name;
    }

    public function created_at(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updated_at(): DateTime
    {
        return $this->updatedAt;
    }

    public static function create(
        AttributeSetId $id,
        AttributeSetName $name
    ): AttributeSet {
        return new self($id, $name);
    }
}