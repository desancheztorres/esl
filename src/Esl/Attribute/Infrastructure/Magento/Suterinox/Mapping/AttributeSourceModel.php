<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Attribute\Infrastructure\Magento\Suterinox\Mapping;

use Arcmedia\Esl\Attribute\Domain\Exception\AttributeIsEmpty;
use Arcmedia\Esl\Attribute\Domain\Exception\AttributeNotValid;

final class AttributeSourceModel
{
    private string $value;
    private array $types = [
        'int' => '',
        'bool' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
        'varchar' => '',
        'text' => '',
        'date' => '',
        'decimal' => '',
        'select' => 'Magento\Eav\Model\Entity\Attribute\Source\Table',
        'multiselect' => ''
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
            throw new AttributeIsEmpty('Attribute source model is empty.');
        }
    }

    private function ensureValueIsValid(string $value): void
    {
        if (!array_key_exists($value, $this->types)) {
            throw new AttributeNotValid("Attribute source model `$value` is not valid.");
        }
    }
}
