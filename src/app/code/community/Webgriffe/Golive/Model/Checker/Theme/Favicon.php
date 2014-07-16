<?php
class Webgriffe_Golive_Model_Checker_Theme_Favicon
    extends Webgriffe_Golive_Model_Checker_Abstract
{
    // To obtain this value, run the following command:
    // $ md5sum <filename>
    const MD5SUM_DEFAULT_FAVICON = "88733ee53676a47fc354a61c32516e82";

    public function check($parameters = array())
    {
        $this->validateParameters($parameters);

        $theme = $parameters['theme'];

        $filename = Mage::getBaseDir('skin').DS.'frontend'.DS.$theme.DS.'favicon.ico';
        $currentFaviconMd5 = md5_file($filename);
        if ($currentFaviconMd5 == self::MD5SUM_DEFAULT_FAVICON) {
            return $this->getDefaultSeverity();
        }

        return self::SEVERITY_NONE;
    }

    /**
     * If theme is not passed as parameter, it's taken from configuration.
     * If not configured, fallback to <default package/default theme>.
     *
     * @param $parameters
     */
    public function validateParameters(&$parameters)
    {
        $this->_logger->info("Parameters before validate(): %s", print_r($parameters, 1));
        parent::validateParameters($parameters);

        if (!isset($parameters['theme']))
        {
            $package = Mage::getStoreConfig('design/package/name', $parameters['store_id']);
            if (empty($package)) {
                $package = Mage_Core_Model_Design_Package::DEFAULT_PACKAGE;
            }

            $theme = Mage::getStoreConfig('design/theme/default', $parameters['store_id']);
            if (empty($theme)) {
                $theme = Mage_Core_Model_Design_Package::DEFAULT_THEME;
            }

            $parameters['theme'] = $package.DS.$theme;
        }
        $this->_logger->info("Parameters after validate(): %s", print_r($parameters, 1));
    }

}