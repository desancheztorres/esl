<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Attribute\Domain\ValueObject;

use Arcmedia\Esl\Attribute\Domain\Exception\ProductAttributeNotFound;

final class AttributeSearchable
{
    private int $value;
    private const NO = 'Nein';
    private const YES = 'Ja';

    private const ALLOWED_VALUES = [
        self::NO => 0,
        self::YES => 1
    ];

    public function __construct(int $value)
    {
//        $this->validate($value);
        $this->value = $value;
    }

    public function value(): int
    {
//        return self::ALLOWED_VALUES[$this->value];
        return $this->value;
    }

    private function validate(int $value): void
    {
        if (empty($value) || !array_key_exists($value, self::ALLOWED_VALUES)) {
            throw new ProductAttributeNotFound("Attribute searchable with value `$value` not found.");
        }
    }
}