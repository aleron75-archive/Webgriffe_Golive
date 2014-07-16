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

        switch ($this->getFaultOperand())
        {
            case 'neq':
                $result = $this->getDefaultConfigValue() != $configuredValue;
                break;
            case 'eq':
                // break intentionally omitted: 'eq' is default fault operand
            default:
                $result = $this->getDefaultConfigValue() == $configuredValue;
        }

        if ($result) {
            return $this->getDefaultSeverity();
        }

        return self::SEVERITY_NONE;
    }

}