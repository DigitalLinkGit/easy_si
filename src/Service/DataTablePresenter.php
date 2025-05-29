<?php
namespace App\Service;

use App\Entity\DataTable;

class DataTablePresenter
{
    public function getHeaders(DataTable $DataTable): array
    {
        $headers = [];

        foreach ($DataTable->getCells() as $cell) {
            $colIndex = $cell->getColIndex();
            $headers[$colIndex] = $cell->getColumnName();
        }

        ksort($headers);
        return array_values($headers);
    }

    public function getMatrix(DataTable $DataTable): array
    {
        $matrix = [];

        foreach ($DataTable->getCells() as $cell) {
            $matrix[$cell->getRowIndex()][$cell->getColIndex()] = $cell;
        }

        ksort($matrix);
        foreach ($matrix as &$row) {
            ksort($row);
        }

        return $matrix;
    }

    public function toTwigModel(DataTable $DataTable): array
    {
        return [
            'headers' => $this->getHeaders($DataTable),
            'matrix'  => $this->getMatrix($DataTable),
        ];
    }
}
