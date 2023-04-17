<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Attribute\Infrastructure\Magento\Suterinox\Mapping;

use Arcmedia\Esl\Attribute\Domain\Exception\AttributeInBlackList;
use Arcmedia\Esl\Attribute\Domain\Exception\AttributeIsEmpty;
use Arcmedia\Shared\Domain\StringFormatter;

final class AttributeCode
{
    private array $blacklist = [
        'BruttopreisCHFinklMWSt23',
        'BruttopreisCHFexklMWSt22',
        'Artikelnummer5',
        'ValidFrom',
        'ArtikelKurzbeschreibung1',
        'MLangbeschreibungauto609',
        'MWarenkategorieOnline606',
        'MProduktlinieOnline607',
        'MProduktgruppeOnline608'
    ];
    private string $value;

    public function __construct(string $value)
    {
        $attribute = $this->clean($value);
        $this->validate($attribute);
        $this->value = $attribute;
    }

    public function value(): string
    {
        return $this->value;
    }

    private function clean(string $value): string
    {
        $noUmlauts = StringFormatter::convertUmlauts($value);
        return preg_replace('/[^A-Za-z0-9]/u', '', $noUmlauts);
    }

    private function validate(string $value): void
    {
        $this->ensureValueExists($value);
        $this->ensureIsNotInBlackList($value);
    }

    private function ensureValueExists(string $value): void
    {
        if (empty($value)) {
            throw new AttributeIsEmpty('Attribute code is empty');
        }
    }

    private function ensureIsNotInBlackList(string $value): void
    {
        if (in_array($value, $this->blacklist)) {
            throw new AttributeInBlackList("Attribute code with value `$value` is in blacklist.");
        }
    }
}
