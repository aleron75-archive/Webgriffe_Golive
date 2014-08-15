<?php
class Webgriffe_Golive_Helper_Output extends Mage_Core_Helper_Abstract
{
    const COLOR_RED     = 31;
    const COLOR_YELLOW  = 33;
    const COLOR_CYAN    = 36;

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
     * printTr(array('col1', 'col2', 'col3'), array('10', '-10', '5'));
     *
     * @param array $columns
     */
    public function printTr($columnStrings, $columnStyles, $columnColors = null)
    {
        $colcount = count($columnStrings);
        if ($colcount != count($columnStyles)) {
            throw new Exception("Number of columns must match");
        }

        if (is_string($columnColors) || is_int($columnColors)) {
            $columnColors = array_fill(0, $colcount, $columnColors);
        }

        $mask = '';
        for ($i = 0; $i < $colcount; $i ++)
        {
            if (!is_null($columnColors) && isset($columnColors[$i])) {
                $mask .= "| \033[".$columnColors[$i]."m%".$columnStyles[$i]."s\033[0m ";
            } else {
                $mask .= '| %' . $columnStyles[$i] . 's ';
            }
        }
        $mask .= '|';

        $str = vsprintf($mask, $columnStrings);
        $this->printLine($str);
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