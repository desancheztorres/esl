<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Attribute\Domain\ValueObject;

use Arcmedia\Esl\Attribute\Domain\Exception\ProductAttributeNotFound;

final class AttributeName
{
    private string $value;
    private const DEFAULT_NAMES = [
        'Gewicht brutto#154' => 'Gewicht Brutto',
        'Gewicht netto#155' => 'Gewicht Netto',
        'Bruttopreis CHF exkl. MWSt. gültig ab#402' => 'Preis gültig ab'
    ];

    public function __construct(
        private readonly string $code,
        string $value
    )
    {
        $this->validate($value);
        $this->value = $value;
    }

    public function value(): string
    {
        if (array_key_exists($this->code, self::DEFAULT_NAMES)) {
            return self::DEFAULT_NAMES[$this->code];
        }

        return $this->value;
    }

    private function validate(string $value): void
    {
        $this->ensureValueExists($value);
    }

    private function ensureValueExists(string $value): void
    {
        if (empty($value)) {
            throw new ProductAttributeNotFound('Attribute name not found.');
        }
    }
}