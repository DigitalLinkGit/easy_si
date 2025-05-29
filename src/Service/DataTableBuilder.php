<?php

namespace App\Service;

use App\Entity\DataTable;
use App\Entity\DataTableCell;

class DataTableBuilder
{
    public function fromArray(array $data, string $source): DataTable
    {
        $table = new DataTable();

        $rowIndex = 0;
        foreach ($data as $row) {
            $colIndex = 0;
            foreach ($row as $key => $value) {
                $cell = new DataTableCell();
                $cell->setDataTable($table);
                $cell->setRowIndex($rowIndex);
                $cell->setColIndex($colIndex);
                $cell->setColumnName($key);
                $cell->setValue(is_array($value) || is_object($value) ? json_encode($value) : (string) $value);
                $table->addCell($cell);
                $colIndex++;
            }
            $rowIndex++;
        }

        return $table;
    }

    public function getStructuredRows(DataTable $table): array
    {
        $rows = [];
        foreach ($table->getCells() as $cell) {
            $rowIdx = $cell->getRowIndex();
            $colName = $cell->getColumnName();
            $rows[$rowIdx][$colName] = $cell->getValue();
        }
        ksort($rows);
        return array_values($rows); // reset index
    }

    public function getGroupedCells(DataTable $table): array
    {
        $grouped = [];
        foreach ($table->getCells() as $cell) {
            $rowIndex = $cell->getRowIndex();
            $colName = $cell->getColumnName();
            $grouped[$rowIndex][$colName] = $cell;
        }

        ksort($grouped);
        return $grouped;
    }
}
