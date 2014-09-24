<?php

namespace Facturizer;

class TextHelper
{
    public static function mb_str_pad( $input, $pad_length, $pad_string = ' ', $pad_type = STR_PAD_RIGHT)
    {
        $diff = strlen( $input ) - mb_strlen( $input );
        return str_pad( $input, $pad_length + $diff, $pad_string, $pad_type );
    }

    public static function buildTable($data, $columnPadding = 2)
    {
        $window    = \Hoa\Console\Window::getSize();
        $windowWidth = $window['x'];

        $minimalColumnWidths = [];
        $optimalColumnWidths = array_fill(0, count($data[0]), 0);

        /*
         * Determine widths for all columns
         */
        foreach ($data as $rowIndex => $row) {
            foreach ($row as $columnIndex => $column) {
                if ($rowIndex == 0) {
                    $minimalColumnWidths[$columnIndex] = mb_strlen($column) + $columnPadding;
                }

                $currentColumnWidth = mb_strlen($column) + $columnPadding;
                if ($currentColumnWidth > $optimalColumnWidths[$columnIndex]) {
                    $optimalColumnWidths[$columnIndex] = $currentColumnWidth;
                }
            }
        }

        if (array_sum($optimalColumnWidths) > $windowWidth) {
            /*
             *  Printing all columns with their optimal widths does not the
             *  window, so some columns have to be shortened
             */
            $charactersToGain = array_sum($optimalColumnWidths) - $windowWidth;
            $slimColumns = function ($columns) use ($minimalColumnWidths, $windowWidth) {
                while (array_sum($columns) > $windowWidth) {
                    array_walk($columns, function (&$column, $index, $minimalColumnWidths) {
                        /*
                         * Slim each column by 1 character while
                         * preserving the minimal width to print
                         * the column headers:
                         */
                        if ($column > $minimalColumnWidths[$index]) {
                            $column = $column - 1;
                        }
                    }, $minimalColumnWidths);
                }
                return $columns;
            };
            $columnWidths = $slimColumns($optimalColumnWidths);
        } else {
            /*
             * All columns with their optimal widths fit the window - we're golden
             */
            $columnWidths = $optimalColumnWidths;
        }

        /*
         * Print table contents
         */
        $stringRows = [];
        foreach($data as $row) {
            $paddedColumns = [];
            foreach ($row as $columnIndex => $columnContent) {
                /*
                 * Check if the column content has to be
                 * truncated in order to fit the column:
                 */
                if (mb_strlen($columnContent) > $columnWidths[$columnIndex]) {
                    $columnContent = substr($columnContent, 0, $columnWidths[$columnIndex] - $columnPadding - 1) . '…';
                }
                $paddedColumns[] = self::mb_str_pad($columnContent, $columnWidths[$columnIndex]);
            }
            $stringRows[] = implode('', $paddedColumns);
        }
        return implode(PHP_EOL, $stringRows).PHP_EOL;
    }
}
