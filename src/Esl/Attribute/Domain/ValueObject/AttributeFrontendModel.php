<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Attribute\Domain\ValueObject;

use Arcmedia\Esl\Attribute\Domain\Exception\ProductAttributeNotFound;

final class AttributeFrontendModel
{
    private string $value;
    private const INTEGER = 'int';
    private const BOOLEAN = 'bool';
    private const VARCHAR = 'varchar';
    private const TEXT = 'text';
    private const DATE = 'date';
    private const DECIMAL = 'decimal';
    private const SELECT = 'select';
    private const MULTISELECT = 'multiselect';

    private const ALLOWED_VALUES = [
        self::INTEGER => '',
        self::BOOLEAN => '',
        self::VARCHAR => '',
        self::TEXT => '',
        self::DATE => 'Magento\Eav\Model\Entity\Attribute\Frontend\Datetime',
        self::DECIMAL => '',
        self::SELECT => '',
        self::MULTISELECT => ''
    ];

    public function __construct(string $value)
    {
//        $this->validate($value);
        $this->value = $value;
    }

    public function value(): string
    {
//        return self::ALLOWED_VALUES[$this->value];
        return $this->value;
    }

    private function validate(string $value): void
    {
        if (!array_key_exists($value, self::ALLOWED_VALUES)) {
            throw new ProductAttributeNotFound("Attribute frontend model with value `$value` not found.");
        }
    }
}