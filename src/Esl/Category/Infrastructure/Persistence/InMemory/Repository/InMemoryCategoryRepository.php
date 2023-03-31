<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Category\Infrastructure\Persistence\InMemory\Repository;

use Arcmedia\Esl\Category\Domain\Category;
use Arcmedia\Esl\Category\Domain\CategoryCollection;
use Arcmedia\Esl\Category\Domain\Contract\CategoryRepository;
use Arcmedia\Esl\Category\Domain\ValueObject\CategoryId;
use Arcmedia\Esl\Category\Domain\ValueObject\CategoryIsActive;
use Arcmedia\Esl\Category\Domain\ValueObject\CategoryLevel;
use Arcmedia\Esl\Category\Domain\ValueObject\CategoryName;
use Arcmedia\Esl\Category\Domain\ValueObject\CategoryParent;
use Ramsey\Uuid\Uuid;

final class InMemoryCategoryRepository implements CategoryRepository
{
    private array $categoriesArr = [
        [
            "name" => "Produkte",
            "parent_id" => "0",
            "include_in_menu" => true,
            "is_active" => 1,
            "level" => 1
        ],
        [
            "name" => "Spülen und Becken",
            "parent_id" => "produkte",
            "include_in_menu" => true,
            "is_active" => 1,
            "level" => 2
        ],
        [
            "name" => "Haushaltsgeräte",
            "parent_id" => "produkte",
            "include_in_menu" => true,
            "is_active" => 1,
            "level" => 2
        ],
        [
            "name" => "Handelswaren",
            "parent_id" => "produkte",
            "include_in_menu" => true,
            "is_active" => 1,
            "level" => 2
        ],
        [
            "name" => "Kühlen",
            "parent_id" => "Haushaltsgeräte",
            "include_in_menu" => true,
            "is_active" => 1,
            "level" => 3
        ],
        [
            "name" => "Ersatzteile",
            "parent_id" => "Haushaltsgeräte",
            "include_in_menu" => true,
            "is_active" => 1,
            "level" => 3
        ],
        [
            "name" => "Zubehör",
            "parent_id" => "Haushaltsgeräte",
            "include_in_menu" => true,
            "is_active" => 1,
            "level" => 3
        ],
        [
            "name" => "Waschen",
            "parent_id" => "Haushaltsgeräte",
            "include_in_menu" => true,
            "is_active" => 1,
            "level" => 3
        ],
        [
            "name" => "Dunstabzug",
            "parent_id" => "Haushaltsgeräte",
            "include_in_menu" => true,
            "is_active" => 1,
            "level" => 3
        ],
        [
            "name" => "Becken",
            "parent_id" => "Spülen und Becken",
            "include_in_menu" => true,
            "is_active" => 1,
            "level" => 3
        ],
        [
            "name" => "Armaturen",
            "parent_id" => "Handelswaren",
            "include_in_menu" => true,
            "is_active" => 1,
            "level" => 3
        ],
        [
            "name" => "Geschirrspüler",
            "parent_id" => "Haushaltsgeräte",
            "include_in_menu" => true,
            "is_active" => 1,
            "level" => 3
        ],
        [
            "name" => "Backen",
            "parent_id" => "Haushaltsgeräte",
            "include_in_menu" => true,
            "is_active" => 1,
            "level" => 3
        ],
        [
            "name" => "Kochen",
            "parent_id" => "Haushaltsgeräte",
            "include_in_menu" => true,
            "is_active" => 1,
            "level" => 3
        ],
        [
            "name" => "Unterbaubecken",
            "parent_id" => "Becken",
            "include_in_menu" => true,
            "is_active" => 1,
            "level" => 4
        ],
        [
            "name" => "Ersatzteile",
            "parent_id" => "Ersatzteile",
            "include_in_menu" => true,
            "is_active" => 1,
            "level" => 4
        ],
        [
            "name" => "Wäschetrockner",
            "parent_id" => "Waschen",
            "include_in_menu" => true,
            "is_active" => 1,
            "level" => 4
        ],
        [
            "name" => "Ersatzteile",
            "parent_id" => "Waschen",
            "include_in_menu" => true,
            "is_active" => 1,
            "level" => 4
        ],
        [
            "name" => "Wasch Trockensäulen",
            "parent_id" => "Waschen",
            "include_in_menu" => true,
            "is_active" => 1,
            "level" => 4
        ],
        [
            "name" => " Samsung",
            "parent_id" => "Zubehör",
            "include_in_menu" => true,
            "is_active" => 1,
            "level" => 4
        ],
        [
            "name" => " Bora",
            "parent_id" => "Ersatzteile",
            "include_in_menu" => true,
            "is_active" => 1,
            "level" => 4
        ],
        [
            "name" => "Geschirrspüler",
            "parent_id" => "Geschirrspüler",
            "include_in_menu" => true,
            "is_active" => 1,
            "level" => 4
        ],
        [
            "name" => "Waschmaschinen",
            "parent_id" => "Waschen",
            "include_in_menu" => true,
            "is_active" => 1,
            "level" => 4
        ],
        [
            "name" => "Kanalsysteme",
            "parent_id" => "Kochen",
            "include_in_menu" => true,
            "is_active" => 1,
            "level" => 4
        ],
        [
            "name" => "Dunstabzugshauben",
            "parent_id" => "Dunstabzug",
            "include_in_menu" => true,
            "is_active" => 1,
            "level" => 4
        ],
        [
            "name" => "Kochfeldabzugssysteme",
            "parent_id" => "Kochen",
            "include_in_menu" => true,
            "is_active" => 1,
            "level" => 4
        ],
        [
            "name" => "Kochfelder",
            "parent_id" => "Kochen",
            "include_in_menu" => true,
            "is_active" => 1,
            "level" => 4
        ],
        [
            "name" => "Backöfen",
            "parent_id" => "Backen",
            "include_in_menu" => true,
            "is_active" => 1,
            "level" => 4
        ],
        [
            "name" => " Samsung",
            "parent_id" => "Ersatzteile",
            "include_in_menu" => true,
            "is_active" => 1,
            "level" => 4
        ],
        [
            "name" => "Kühlgeräte",
            "parent_id" => "Kühlen",
            "include_in_menu" => true,
            "is_active" => 1,
            "level" => 4
        ],
        [
            "name" => "Küchenarmaturen",
            "parent_id" => "Armaturen",
            "include_in_menu" => true,
            "is_active" => 1,
            "level" => 4
        ]
    ];
    /** @var Category[]  */
    private array $categories;

    public function __construct()
    {
        foreach ($this->categoriesArr as $category) {
            $this->categories[] = new Category(
                id: new CategoryId(Uuid::uuid4()->toString()),
                name: new CategoryName($category['name']),
                parent: new CategoryParent($category['parent_id']),
                isActive: new CategoryIsActive($category['is_active']),
                level: new CategoryLevel($category['level']),
            );
        }
    }

    public function findAll(): CategoryCollection
    {
        $categoryCollection = new CategoryCollection();

        array_map(function (Category $category) use ($categoryCollection) {
            $categoryCollection->add($category);
        }, $this->categories);

        return $categoryCollection;

    }

    public function save(Category $category): void
    {
    }
}