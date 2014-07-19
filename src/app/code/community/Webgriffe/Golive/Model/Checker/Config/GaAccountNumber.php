<?php
class Webgriffe_Golive_Model_Checker_Config_GaAccountNumber
    extends Webgriffe_Golive_Model_Checker_Abstract
{
    public function check($parameters = array())
    {
        $this->validateParameters($parameters);

        $gaActive = Mage::getStoreConfig('google/analytics/active', $parameters['store_id']);

        if (!empty($gaActive)) {
            $gaAccountNumber = Mage::getStoreConfig('google/analytics/account', $parameters['store_id']);
            if (empty($gaAccountNumber)) {
                return $this->getDefaultSeverity();
            }
        }

        return self::SEVERITY_SKIP;
    }
}