<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Attribute\Domain\Contract;

use Arcmedia\Esl\Attribute\Domain\Attribute;
use Arcmedia\Esl\Attribute\Domain\AttributeCollection;

interface AttributeRepository
{
    public function findAll(): AttributeCollection;
    public function save(Attribute $attribute): void;
}