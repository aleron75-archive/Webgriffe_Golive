<?php

class Webgriffe_Golive_Model_Checker_Config_UnsecureBaseUrl extends Webgriffe_Golive_Model_Checker_Abstract
{

    /**
     * @param array $parameters
     * @return string
     */
    public function check($parameters = array())
    {
        if (!isset($parameters['domain'])) {
            return $this->getDefaultSeverity();
        }

        if (!isset($parameters['store_id'])) {
            $parameters['store_id'] = null;
        }

        $configuredUnsecureBaseUrl = Mage::getStoreConfig(
            'web/unsecure/base_url',
            $parameters['store_id']
        );

        $domain = $parameters['domain'];
        $valueToCheck = sprintf('http://%s/', $domain);

        if ($configuredUnsecureBaseUrl != $valueToCheck)
        {
            return $this->getDefaultSeverity();
        }

        return self::SEVERITY_NONE;
    }
}