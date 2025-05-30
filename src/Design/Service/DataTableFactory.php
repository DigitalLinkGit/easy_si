<?php

namespace App\Design\Service;

use App\Design\Entity\DataTable;
use App\Design\Entity\DataTableCell;

class DataTableFactory
{
    public function createFromArray(array $rows, string $source = ''): DataTable
    {
        $table = new DataTable();
        $table->setName("Import $source - " . date('Y-m-d H:i:s'));
        //$table->settype('Odata'); // 'odata', 'soap', 'file', ...

        // Étape 1 : collecter toutes les colonnes possibles
        $allColumnNames = [];
        foreach ($rows as $row) {
            foreach ($row as $key => $_) {
                $allColumnNames[$key] = true;
            }
        }
        $orderedColumns = array_keys($allColumnNames); // garde l'ordre d'apparition

        // Étape 2 : générer les cellules normalisées
        foreach ($rows as $rowIndex => $row) {
            foreach ($orderedColumns as $colIndex => $columnName) {
                $value = $row[$columnName] ?? ''; // valeur vide si manquante
                $cell = new DataTableCell();
                $cell->setDataTable($table);
                $cell->setRowIndex($rowIndex);
                $cell->setColIndex($colIndex);
                $cell->setColumnName($columnName);
                $cell->setValue(is_scalar($value) ? (string) $value : json_encode($value));
                $table->addCell($cell);
            }
        }

        return $table;
    }
}
