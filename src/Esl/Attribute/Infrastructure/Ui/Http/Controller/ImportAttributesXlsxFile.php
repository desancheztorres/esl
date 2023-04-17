<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Attribute\Infrastructure\Ui\Http\Controller;

use Arcmedia\Esl\Attribute\Application\Command\SaveAttributesHandler;
use Arcmedia\Esl\Attribute\Application\Request\CreateAttributeRequest;
use Arcmedia\Esl\Attribute\Infrastructure\Magento\Suterinox\Mapping\AttributeBackendModel;
use Arcmedia\Esl\Attribute\Infrastructure\Magento\Suterinox\Mapping\AttributeBackendType;
use Arcmedia\Esl\Attribute\Infrastructure\Magento\Suterinox\Mapping\AttributeCode;
use Arcmedia\Esl\Attribute\Infrastructure\Magento\Suterinox\Mapping\AttributeDescription;
use Arcmedia\Esl\Attribute\Infrastructure\Magento\Suterinox\Mapping\AttributeFilterable;
use Arcmedia\Esl\Attribute\Infrastructure\Magento\Suterinox\Mapping\AttributeFrontendInput;
use Arcmedia\Esl\Attribute\Infrastructure\Magento\Suterinox\Mapping\AttributeFrontendModel;
use Arcmedia\Esl\Attribute\Infrastructure\Magento\Suterinox\Mapping\AttributeName;
use Arcmedia\Esl\Attribute\Infrastructure\Magento\Suterinox\Mapping\AttributeSearchable;
use Arcmedia\Esl\Attribute\Infrastructure\Magento\Suterinox\Mapping\AttributeSourceModel;
use Arcmedia\Esl\Attribute\Infrastructure\Magento\Suterinox\Mapping\AttributeType;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Row;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ImportAttributesXlsxFile
{
    private array $attributes = [];
    private array $columns = [];
    private int $startRow = 1;
    private string $startColumn = "A";
    private int $totalRows;
    private string $totalColumns;

    public function __construct(
        private readonly SaveAttributesHandler $handler,
    ) {
    }

    public function __invoke()
    {
        try {
            $this->readFile();

            $response = new JsonResponse([
                'data' => $this->attributes(),
                'total' => count($this->attributes()),
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

    private function readFile()
    {
        $filename = __DIR__ . '/../../../../../../../eslimport/attributes.xlsx';
        $sheetName = "Tabelle1";
        $inputFileType = 'Xlsx';

        $reader = IOFactory::createReader($inputFileType);
        $reader->setReadDataOnly(true);
        $reader->setLoadSheetsOnly($sheetName);
        $spreadsheet = $reader->load($filename);
        $worksheet = $spreadsheet->getActiveSheet();

        $this->totalRows = $worksheet->getHighestDataRow();
        $this->totalColumns = $worksheet->getHighestDataColumn();

        foreach ($worksheet->getRowIterator($this->startRow, $this->totalRows) as $row) {
            $this->setColumns($row);

            if ($row->getRowIndex() === $this->startRow) {
                continue;
            }

            $cells = iterator_to_array(
                $row->getCellIterator(array_key_first($this->columns), array_key_last($this->columns))
            );

            try {
                $code = new AttributeCode($this->getColumnValue($cells, $this->columnsAllowed()['code']));
                $name = new AttributeName($code->value(), $this->getColumnValue($cells, $this->columnsAllowed()['name']));
                $description = new AttributeDescription($this->getColumnValue($cells, $this->columnsAllowed()['description']));
                $filterable = new AttributeFilterable($this->getColumnValue($cells, $this->columnsAllowed()['filterable']));
                $type = new AttributeType(
                    value: $this->getColumnValue($cells, $this->columnsAllowed()['type']),
                    is_filterable: $filterable->value()
                );
                $searchable = new AttributeSearchable($this->getColumnValue($cells, $this->columnsAllowed()['searchable']));
                $backendType = new AttributeBackendType($type->value());
                $backendModel = new AttributeBackendModel($type->value());
                $frontendInput = new AttributeFrontendInput($type->value());
                $frontendModel = new AttributeFrontendModel($type->value());
                $sourceModel = new AttributeSourceModel($type->value());

                $this->handler->__invoke(
                    new CreateAttributeRequest(
                        code: $code->value(),
                        name: $name->value(),
                        searchable: $searchable->value(),
                        filterable: $filterable->value(),
                        description: $description->value(),
                        backendType: $backendType->value(),
                        backendModel: $backendModel->value(),
                        frontendInput: $frontendInput->value(),
                        frontendModel: $frontendModel->value(),
                        sourceModel: $sourceModel->value()
                    )
                );
            } catch (\Exception $e) {
                var_dump("Error while importing attribute from file in row {$row->getRowIndex()}: {$e->getMessage()}");
            }
        }
    }

    private function attributes(): array
    {
        return array_map("unserialize", array_unique(array_map("serialize", $this->attributes)));
    }

    /**
     * @throws Exception
     */
    private function setColumns(Row $row): void
    {
        if ($row->getRowIndex() === $this->startRow) {
            foreach ($row->getCellIterator($this->startColumn, $this->totalColumns) as $column) {
                $this->columns[$column->getColumn()] = $column->getValue();
            }
        }
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

    private function columnsAllowed(): array
    {
        return [
            'code' => 'Feld',
            'name' => 'Feldname',
            'type' => 'Feldtyp',
            'searchable' => 'Suchbar',
            'filterable' => 'Filtrierbar',
            'description' => 'Beschreibung',
            'value' => 'Werte'
        ];
    }
}
