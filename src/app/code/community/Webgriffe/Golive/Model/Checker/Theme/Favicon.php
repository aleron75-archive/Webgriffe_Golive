<?php
class Webgriffe_Golive_Model_Checker_Theme_Favicon
    extends Webgriffe_Golive_Model_Checker_Abstract
{
    // To obtain this value, run the following command:
    // $ md5sum <filename>
    const MD5SUM_DEFAULT_FAVICON = "88733ee53676a47fc354a61c32516e82";

    public function check($parameters = array())
    {
        if (!isset($parameters['theme'])) {
            Mage::throwException(sprintf("Parameter 'theme' is missing."));
        }

        $theme = $parameters['theme'];

        $filename = Mage::getBaseDir('skin').DS.'frontend'.DS.$theme.DS.'favicon.ico';
        $currentFaviconMd5 = md5_file($filename);
        if ($currentFaviconMd5 == self::MD5SUM_DEFAULT_FAVICON) {
            return $this->getDefaultSeverity();
        }

        return self::SEVERITY_NONE;
    }
}