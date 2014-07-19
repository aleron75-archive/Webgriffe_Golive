<?php
class Webgriffe_Golive_Model_Checker_Data_CacheEnabled
    extends Webgriffe_Golive_Model_Checker_Abstract
{
    public function check($parameters = array())
    {
        $this->validateParameters($parameters);
        $cacheType = $this->getCacheType();

        $caches = Mage::app()->useCache();
        if (!array_key_exists($cacheType, $caches)) {
            $msg = sprintf("Unrecognized cache type '%s'", $cacheType);
            $this->_logger->error($msg);
            Mage::throwException($msg);
        }

        if ($caches[$cacheType] == 0) {
            return $this->getDefaultSeverity();
        }
        return self::SEVERITY_NONE;
    }

}