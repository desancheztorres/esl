<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Category\Domain\ValueObject;

use Arcmedia\Esl\Category\Domain\Exception\CategoryNotFound;
use Arcmedia\Esl\Shared\Domain\Service\StringFormatter;

final class CategoryName
{
    private string $value;

    public function __construct(string $value)
    {
        $category = $this->clean($value);
        $this->validate($category);
        $this->value = $category;
    }

    public function value(): string
    {
        return preg_replace('/\s+/', ' ', $this->value);
    }

    public function valueFormatted(): string
    {
        $value = strtolower(StringFormatter::convertUmlauts($this->value));

        return preg_replace('/[^a-zA-Z]/', '', $value);
    }

    private function validate(string $value): void
    {
        $this->ensureValueExists($value);
    }

    private function clean(string $value): string
    {
        return trim(preg_replace('/[^A-Za-zäöüÄÖÜß\s]/u', '', $value));
    }

    private function ensureValueExists(string $value): void
    {
        if (empty($value)) {
            throw new CategoryNotFound('Category level not found');
        }
    }
}