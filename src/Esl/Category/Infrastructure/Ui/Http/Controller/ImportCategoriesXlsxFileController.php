<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Category\Infrastructure\Ui\Http\Controller;

use Arcmedia\Esl\Category\Application\Command\SaveManyCategoriesHandler;
use Arcmedia\Esl\Category\Domain\ValueObject\CategoryName;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Row;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ImportCategoriesXlsxFileController
{
    private array $categories = [];
    private array $columns = [];
    private int $startRow = 1;
    private string $startColumn = "A";
    private int $totalRows;
    private string $totalColumns;
    private string $topCategory = 'produkte';

    public function __construct(
        private readonly SaveManyCategoriesHandler $handler,
    ) {
    }

    public function __invoke(): JsonResponse
    {
        try {
            $this->readFile();

            $this->handler->__invoke($this->categories());

            $response = new JsonResponse([
                'data' => $this->categories(),
                'total' => count($this->categories()),
                'status' => 'ok',
            ]);
        } catch (\Exception $exception) {
            $response = new JsonResponse([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $response;
    }

    /**
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    private function readFile(): void
    {
        $filename = __DIR__ . '/../../../../../../../eslimport/products.xlsx';
        $sheetName = "Daten zum Testen";
        $inputFileType = 'Xlsx';

        $reader = IOFactory::createReader($inputFileType);
        $reader->setReadDataOnly(true);
        $reader->setLoadSheetsOnly($sheetName);
        $spreadsheet = $reader->load($filename);
        $worksheet = $spreadsheet->getActiveSheet();

        $this->totalRows = $worksheet->getHighestDataRow();
        $this->totalColumns = $worksheet->getHighestDataColumn();

        $categoriesPath = [];

        $this->categories[] = [
            'name' => $this->topCategory,
            'parent_path' => '',
            'is_active' => 1,
            'level' => 0,
            'path' => $pathTopCategory = $this->topCategory
        ];

        foreach ($worksheet->getRowIterator($this->startRow, $this->totalRows) as $row) {
            $this->setColumns($row);

            if ($row->getRowIndex() === $this->startRow) {
                continue;
            }

            $cells = iterator_to_array(
                $row->getCellIterator(array_key_first($this->columns), array_key_last($this->columns))
            );

            try {
                $categoryLevel1 = new CategoryName(
                    $this->getColumnValue($cells, $this->columnsAllowed()['categoryLevel1'])
                );
                $categoryLevel2 = new CategoryName(
                    $this->getColumnValue($cells, $this->columnsAllowed()['categoryLevel2'])
                );
                $categoryLevel3 = new CategoryName(
                    $this->getColumnValue($cells, $this->columnsAllowed()['categoryLevel3'])
                );

                $fullPath = $categoryLevel1->valueFormatted() . "_" .$categoryLevel2->valueFormatted() . "_" .$categoryLevel3->valueFormatted();

                if (!in_array($fullPath, $categoriesPath)) {
                    $this->addCategories($categoryLevel1, $pathTopCategory, $categoryLevel2, $categoryLevel3);
                }


            } catch (\Exception $e) {
            }
        }
    }

    private function categories(): array
    {
        return array_map("unserialize", array_unique(array_map("serialize", $this->categories)));
    }

    private function columnsAllowed(): array
    {
        return [
            'categoryLevel1' => 'M_Warenkategorie Online#606',
            'categoryLevel2' => 'M_Produktlinie Online#607',
            'categoryLevel3' => 'M_Produktgruppe Online#608',
        ];
    }

    private function getColumnValue(array $cells, string $column): ?string
    {
        if (!in_array($column, $this->columns)) {
            return null;
        }

        $columnName = array_search($column, $this->columns);
        return $cells[$columnName]->getValue() ?? '';
    }

    /**
     * @throws Exception
     */
    private function setColumns(Row $row): void
    {
        if ($row->getRowIndex() === $this->startRow) {
            foreach ($row->getCellIterator($this->startColumn, $this->totalColumns) as $column) {
                $this->columns[$column->getColumn()] = $column->getValue() ?? '';
            }
        }
    }

    public function addCategories(
        CategoryName $categoryLevel1,
        string $pathTopCategory,
        CategoryName $categoryLevel2,
        CategoryName $categoryLevel3
    ): void {
        $this->categories[] = [
            'name' => $categoryLevel1->value(),
            'parent_path' => $pathTopCategory,
            'is_active' => 1,
            'level' => 1,
            'path' => $pathCategory1 = $this->topCategory . "_" . $categoryLevel1->valueFormatted()
        ];

        $this->categories[] = [
            'name' => $categoryLevel2->value(),
            'parent_path' => $pathCategory1,
            'is_active' => 1,
            'level' => 2,
            'path' => $pathCategory2 = $categoryLevel1->valueFormatted() . "_" . $categoryLevel2->valueFormatted()
        ];

        $this->categories[] = [
            'name' => $categoryLevel3->value(),
            'parent_path' => $pathCategory2,
            'is_active' => 1,
            'level' => 3,
            'path' => $categoryLevel2->valueFormatted() . "_" . $categoryLevel3->valueFormatted()
        ];
    }
}