<?php

class Webgriffe_Golive_Model_Checker_Config_UnsecureBaseUrl
    extends Webgriffe_Golive_Model_Checker_Abstract
{
    const XML_CONFIG_PATH = 'web/unsecure/base_url';

    /**
     * @param array $parameters
     * @return string
     */
    public function check($parameters = array())
    {
        $this->validateParameters($parameters);

        $configuredValue = Mage::getStoreConfig(
            self::XML_CONFIG_PATH,
            $parameters['store_id']
        );

        $domain = $parameters['domain'];
        $pattern = '|http[s]{0,1}://'.trim($domain).'/|';
        if (preg_match($pattern, $configuredValue) == 0) {
            return $this->getDefaultSeverity();
        }

        return self::SEVERITY_NONE;
    }

    public function validateParameters(&$parameters)
    {
        $this->_logger->info("Parameters before validate(): %s", print_r($parameters, 1));
        parent::validateParameters($parameters);

        if (!isset($parameters['domain'])) {
            $this->_logger->error("Parameter 'domain' is missing.");
            Mage::throwException(sprintf("Parameter 'domain' is missing."));
        }
        $this->_logger->info("Parameters after validate(): %s", print_r($parameters, 1));
    }
}