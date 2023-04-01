<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Attribute\Domain;

use Arcmedia\Esl\Attribute\Domain\ValueObject\AttributeBackendModel;
use Arcmedia\Esl\Attribute\Domain\ValueObject\AttributeBackendType;
use Arcmedia\Esl\Attribute\Domain\ValueObject\AttributeCode;
use Arcmedia\Esl\Attribute\Domain\ValueObject\AttributeDescription;
use Arcmedia\Esl\Attribute\Domain\ValueObject\AttributeFilterable;
use Arcmedia\Esl\Attribute\Domain\ValueObject\AttributeFrontendInput;
use Arcmedia\Esl\Attribute\Domain\ValueObject\AttributeFrontendModel;
use Arcmedia\Esl\Attribute\Domain\ValueObject\AttributeId;
use Arcmedia\Esl\Attribute\Domain\ValueObject\AttributeName;
use Arcmedia\Esl\Attribute\Domain\ValueObject\AttributeSearchable;
use Arcmedia\Esl\Attribute\Domain\ValueObject\AttributeSourceModel;
use DateTime;
use DateTimeImmutable;

final class Attribute
{
    private DateTimeImmutable $createdAt;
    private DateTime $updatedAt;

    public function __construct(
        private readonly AttributeId $id,
        private readonly AttributeCode $code,
        private readonly AttributeName $name,
        private readonly AttributeSearchable $searchable,
        private readonly AttributeFilterable $filterable,
        private readonly AttributeDescription $description,
        private readonly AttributeBackendType $backendType,
        private readonly ?AttributeBackendModel $backendModel,
        private readonly AttributeFrontendInput $frontendInput,
        private readonly AttributeFrontendModel $frontendModel,
        private readonly AttributeSourceModel $sourceModel
    )
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTime();
    }

    public function id(): AttributeId
    {
        return $this->id;
    }

    public function code(): AttributeCode
    {
        return $this->code;
    }

    public function name(): AttributeName
    {
        return $this->name;
    }

    public function searchable(): AttributeSearchable
    {
        return $this->searchable;
    }

    public function filterable(): AttributeFilterable
    {
        return $this->filterable;
    }

    public function description(): AttributeDescription
    {
        return $this->description;
    }

    public function backendType(): AttributeBackendType
    {
        return $this->backendType;
    }

    public function backendModel(): ?AttributeBackendModel
    {
        return $this->backendModel;
    }

    public function frontendInput(): AttributeFrontendInput
    {
        return $this->frontendInput;
    }

    public function frontendModel(): AttributeFrontendModel
    {
        return $this->frontendModel;
    }

    public function sourceModel(): AttributeSourceModel
    {
        return $this->sourceModel;
    }

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public static function create(
        AttributeId $id,
        AttributeCode $code,
        AttributeName $name,
        AttributeSearchable $searchable,
        AttributeFilterable $filterable,
        AttributeDescription $description,
        AttributeBackendType $backendType,
        AttributeBackendModel $backendModel,
        AttributeFrontendInput $frontendInput,
        AttributeFrontendModel $frontendModel,
        AttributeSourceModel $sourceModel
    ): self
    {
        return new self(
            $id,
            $code,
            $name,
            $searchable,
            $filterable,
            $description,
            $backendType,
            $backendModel,
            $frontendInput,
            $frontendModel,
            $sourceModel
        );
    }
}