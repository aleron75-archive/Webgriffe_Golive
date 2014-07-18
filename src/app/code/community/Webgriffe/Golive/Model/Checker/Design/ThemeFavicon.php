<?php
class Webgriffe_Golive_Model_Checker_Design_ThemeFavicon
    extends Webgriffe_Golive_Model_Checker_File_Md5sum
{
    public function check($parameters = array())
    {
        $this->validateParameters($parameters);
        $theme = $parameters['theme'];
        $this->setFilepath(Mage::getBaseDir('skin').DS.'frontend'.DS.$theme.DS.'favicon.ico');
        return parent::check($parameters);
    }

    /**
     * If theme is not passed as parameter, it's taken from configuration.
     * If not configured, fallback to <default package/default theme>.
     *
     * @param $parameters
     */
    public function validateParameters(&$parameters)
    {
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
    }

}