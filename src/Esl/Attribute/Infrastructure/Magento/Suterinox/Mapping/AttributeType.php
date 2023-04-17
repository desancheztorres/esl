<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Attribute\Infrastructure\Magento\Suterinox\Mapping;

use Arcmedia\Esl\Attribute\Domain\Exception\AttributeIsEmpty;
use InvalidArgumentException;

final class AttributeType
{
    private string $value;
    private bool $is_filterable;

    public const INTEGER = 'int';
    public const BOOLEAN = 'bool';
    public const VARCHAR = 'varchar';
    public const TEXT = 'text';
    public const DATE = 'date';
    public const DECIMAL = 'decimal';
    public const SELECT = 'select';
    public const MULTISELECT = 'multiselect';

    private array $types = [
        self::INTEGER => 'decimal',
        self::BOOLEAN => 'bool',
        self::VARCHAR => 'varchar',
        self::TEXT => 'text',
        self::DATE => 'select',
        self::DECIMAL => 'decimal',
        self::SELECT => 'select',
        self::MULTISELECT => 'multiselect',
    ];

    public function __construct(string $value, bool $is_filterable)
    {
        $this->validate($value);
        $this->value = $value;
        $this->is_filterable = $is_filterable;
    }

    public function value(): string
    {
        if ($this->is_filterable) {
            return $this->types[$this->value];
        }

        return $this->value;
    }

    private function validate(string $value): void
    {
        $this->ensureValueExists($value);
        $this->ensureValueIsValid($value);
    }

    private function ensureValueExists(string $value): void
    {
        if (empty($value)) {
            throw new AttributeIsEmpty("Attribute type is empty.");
        }
    }

    private function ensureValueIsValid(string $value): void
    {
        if (!array_key_exists($value, $this->types)) {
            throw new InvalidArgumentException("Attribute type with value `$value` is not valid.");
        }
    }
}
