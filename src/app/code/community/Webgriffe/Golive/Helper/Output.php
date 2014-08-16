<?php
class Webgriffe_Golive_Helper_Output extends Mage_Core_Helper_Abstract
{
    const COLOR_RED     = 31;
    const COLOR_YELLOW  = 33;
    const COLOR_CYAN    = 36;
    const COLOR_DEFAULT = 39;

    public function getLines($str, $width = 72, $cut = false)
    {
        return explode("\n", wordwrap($str, $width, "\n", $cut));
    }

    public function printLine($str = '', $lineBreaks = 1)
    {
        print $str.str_repeat(PHP_EOL, $lineBreaks);
    }

    /**
     * Usage
     *
     * printTr(array('col1', 'col2', 'col3'), array('10', '-10', '5'), array(31, 33, 36));
     * printTr(array('col1', 'col2', 'col3'), array('10', '-10', '5'), 33);
     *
     * @param array $columns
     */
    public function printTr($columnStrings, $columnStyles, $columnColors = null)
    {
        $numColumns = count($columnStrings);
        if ($numColumns != count($columnStyles)) {
            Mage::throwException("Number of columns must match");
        }

        if (is_string($columnColors) || is_int($columnColors)) {
            $columnColors = array_fill(0, $numColumns, $columnColors);
        }

        $mask = '';
        $cellRows = array();
        $maxCellRows = 0;

        for ($i = 0; $i < $numColumns; $i ++)
        {
            if (!is_null($columnColors) && isset($columnColors[$i])) {
                $mask .= "| \033[" . $columnColors[$i] . "m%" . $columnStyles[$i] . "s\033[0m ";
            } else {
                $mask .= '| %' . $columnStyles[$i] . 's ';
            }
            $width = abs(intval($columnStyles[$i]));
            $lines = $this->getLines($columnStrings[$i], $width);
            $cellRows[] = $lines;
            $maxCellRows = max($maxCellRows, count($lines));
        }
        $mask .= '|';

        for ($rowIndex = 0; $rowIndex < $maxCellRows; $rowIndex ++)
        {
            $row = array();
            for ($colIndex = 0; $colIndex < $numColumns; $colIndex ++)
            {
                $row[] = isset($cellRows[$colIndex][$rowIndex]) ? $cellRows[$colIndex][$rowIndex] : '';
            }
            $this->printLine(vsprintf($mask, $row));
        }
    }

    public function printTl($columnStyles)
    {
        $columnStrings = array();
        foreach ($columnStyles as $style)
        {
            $len = abs(intval($style));
            $columnStrings[] = str_repeat('-', $len);
        }
        $this->printTr($columnStrings, $columnStyles);
    }

}