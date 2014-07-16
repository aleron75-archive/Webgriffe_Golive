<?php
class Webgriffe_Golive_Model_Checker_Config_DefaultValue
    extends Webgriffe_Golive_Model_Checker_Abstract
{
    public function check($parameters = array())
    {
        $this->validateParameters($parameters);

        $configuredValue = Mage::getStoreConfig(
            $this->getXmlConfigPath(),
            $parameters['store_id']
        );

        if ($this->getDefaultConfigValue() == $configuredValue) {
            return $this->getDefaultSeverity();
        }

        return self::SEVERITY_NONE;
    }

}