<?php

declare(strict_types=1);

namespace Arcmedia\Esl\AttributeSet\Domain\Contract;

use Arcmedia\Esl\AttributeSet\Domain\AttributeSet;
use Arcmedia\Esl\AttributeSet\Domain\AttributeSetCollection;

interface AttributeSetRepository
{
    public function findAll(): AttributeSetCollection;
    public function save(AttributeSet $attributeSet): void;
}