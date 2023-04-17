<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Attribute\Infrastructure\Magento\Suterinox\Mapping;

use Arcmedia\Esl\Attribute\Domain\Exception\AttributeIsEmpty;

final class AttributeName
{
    private array $default_names = [
        'Gewicht brutto#154' => 'Gewicht Brutto',
        'Gewicht netto#155' => 'Gewicht Netto',
        'Bruttopreis CHF exkl. MWSt. gültig ab#402' => 'Preis gültig ab'
    ];

    private string $value;

    public function __construct(
        private readonly string $code,
        string $value,
    ) {
        $name = $this->clean($value);
        $this->validate($name);
        $this->value = $name;
    }

    public function value(): string
    {
        if (array_key_exists($this->code, $this->default_names)) {
            return $this->default_names[$this->code];
        }

        return $this->value;
    }

    private function clean(string $name): string
    {
        return preg_replace('/[^a-zA-Z0-9\s]/u', '', $name);
    }

    private function validate(string $name): void
    {
        $this->ensureValueExists($name);
    }

    private function ensureValueExists(string $name): void
    {
        if (empty($name)) {
            throw new AttributeIsEmpty("Attribute name is empty.");
        }
    }
}
