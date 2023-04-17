<?php

declare(strict_types=1);

namespace Arcmedia\Esl\AttributeSet\Infrastructure\Ui\Http\Controller;

use Arcmedia\Esl\Attribute\Application\Query\GetAttributesHandler;
use Arcmedia\Esl\Attribute\Application\Response\AttributeCollectionResponse;
use Arcmedia\Esl\Attribute\Domain\Exception\AttributeNotFound;
use Arcmedia\Esl\AttributeSet\Application\Command\SaveAttributeSetHandler;
use Arcmedia\Esl\AttributeSet\Application\Create\CreateAttributeSetRequest;
use Arcmedia\Esl\AttributeSet\Infrastructure\Magento\Suterinox\Mapping\FileAttributeSetName;
use Arcmedia\Shared\Domain\StringFormatter;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Row;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ImportAttributesSetXlsxFile
{
    private array $columns = [];
    private int $startRow = 2;
    private string $startColumn = "A";
    private int $totalRows;
    private string $totalColumns;
    private AttributeCollectionResponse $attributesResponse;
    private array $attributes;
    private string $defaultAttributeSet = 'MProduktgruppeOnline608';

    public function __construct(
        private readonly GetAttributesHandler $getAttributesHandler,
        private readonly SaveAttributeSetHandler $saveAttributesSetHandler,
    ) {
        $this->attributesResponse = $this->getAttributesHandler->__invoke();
    }

    /**
     * @throws Exception
     */
    public function __invoke()
    {

        try {
            $this->readFile();

            $response = new JsonResponse([
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
     */
    private function readFile(): void
    {
        $filename = __DIR__ . '/../../../../../../../eslimport/products.xlsx';
        $sheetName = "Daten zum Testen";
        $inputFileType = 'Xlsx';

        try {
            $reader = IOFactory::createReader($inputFileType);
            $reader->setReadDataOnly(true);
            $reader->setLoadSheetsOnly($sheetName);
            $spreadsheet = $reader->load($filename);
            $worksheet = $spreadsheet->getActiveSheet();
            $this->totalRows = $worksheet->getHighestDataRow();
            $this->totalColumns = $worksheet->getHighestDataColumn();

            $this->importColumns($worksheet);

            if (empty($this->attributesResponse)) {
                throw new AttributeNotFound('Attributes not found.');
            }
            $this->attributes = array_intersect($this->columns, array_column($this->attributesResponse->toArray(), 'code'));
            $defaultAttributeSetColumn = array_search($this->defaultAttributeSet, $this->columns);

            if (false !== $defaultAttributeSetColumn) {
                $this->attributes[$defaultAttributeSetColumn] = $this->defaultAttributeSet;
            }

            $attributesSet = [];

            foreach ($worksheet->getRowIterator($this->startRow, $this->totalRows) as $row) {
                $attributeSetName = '';
                $attributes = [];
                foreach ($row->getColumnIterator() as $column) {
                    $currentColumnName = $column->getColumn();
                    $currentColumnValue = $column->getValue();

                    if (!array_key_exists($currentColumnName, $this->attributes) || null === $currentColumnValue || $currentColumnValue === "---" || $currentColumnValue === "") {
                        continue;
                    }

                    if ($currentColumnName === $defaultAttributeSetColumn) {
                        $productAttributeSetName = new FileAttributeSetName($column->getValue());
                        $attributeSetName = $productAttributeSetName->value();
                    } else {
                        $attributes[] = $this->attributes[$currentColumnName];
                    }
                }

                if (!empty($attributeSetName)) {
                    $attributesSet[$attributeSetName] = $attributes;
                }
            }

            foreach ($attributesSet as $index => $item) {
                try {
                    $this->saveAttributesSetHandler->__invoke(
                        new CreateAttributeSetRequest(
                            name: $index,
                            attributes: $item
                        )
                    );
                } catch (\Exception $exception) {
                    var_dump($exception->getMessage());
                }
            }
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    private function setColumns(Row $row): void
    {
        if ($row->getRowIndex() === 1) {
            foreach ($row->getCellIterator($this->startColumn, $this->totalColumns) as $column) {
                $columnValue = (string) $column->getValue();
                try {
                    $productAttributeCode = $this->clean($columnValue);
                    $this->columns[$column->getColumn()] = $productAttributeCode;
                } catch (\Exception $e) {
                    var_dump($e->getMessage());
                    continue;
                }
            }
        }
//        var_dump($this->columns);
    }

    private function getColumnValue(array $cells, string $column): ?string
    {
        if (!in_array($column, $this->columns)) {
            // TODO LOG
            return null;
        }

        $columnName = array_search($column, $this->columns);
        return $cells[$columnName]->getValue() ?? '';
    }

    /**
     * @throws Exception
     */
    private function importColumns(Worksheet $worksheet): void
    {
        foreach ($worksheet->getRowIterator(1, $this->totalRows) as $row) {
            $this->setColumns($row);
        }
    }

    private function clean(string $value): string
    {
        $noUmlauts = StringFormatter::convertUmlauts($value);
        return preg_replace('/[^A-Za-z0-9]/u', '', $noUmlauts);
    }
}
