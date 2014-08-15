<?php
class Webgriffe_Golive_Helper_Output extends Mage_Core_Helper_Abstract
{
    public function getLines($str, $width = 72, $cut = false)
    {
        return explode("\n", wordwrap($str, $width, "\n", $cut));
    }

    public function printLine($str = '', $lineBreaks = 1)
    {
        print $str.str_repeat(PHP_EOL, $lineBreaks);
    }

}