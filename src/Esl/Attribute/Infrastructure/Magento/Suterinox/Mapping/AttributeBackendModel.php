<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Attribute\Infrastructure\Magento\Suterinox\Mapping;

use Arcmedia\Esl\Attribute\Domain\Exception\AttributeIsEmpty;
use InvalidArgumentException;

final class AttributeBackendModel
{
    private string $value;
    private array $types = [
        'int' => '',
        'bool' => '',
        'varchar' => '',
        'text' => '',
        'date' => 'Magento\Eav\Model\Entity\Attribute\Backend\Datetime',
        'decimal' => '',
        'select' => '',
        'multiselect' => 'Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend'
    ];

    public function __construct(string $value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->types[$this->value];
    }

    private function validate(string $value): void
    {
        $this->ensureValueExists($value);
        $this->ensureValueIsValid($value);
    }

    private function ensureValueExists(string $value): void
    {
        if (empty($value)) {
            throw new AttributeIsEmpty('Attribute backend model is empty.');
        }
    }

    private function ensureValueIsValid(string $value): void
    {
        if (!array_key_exists($value, $this->types)) {
            throw new InvalidArgumentException("Attribute backend model `$value` not found.");
        }
    }
}
