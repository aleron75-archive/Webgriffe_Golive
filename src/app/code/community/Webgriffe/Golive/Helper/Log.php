<?php
class Webgriffe_Golive_Helper_Log extends Mage_Core_Helper_Abstract
{
    const LOG_FILENAME = 'Webgriffe_golive.log';

    private $_forceLog;

    public function __construct()
    {
        $this->_forceLog = $forceLog = Mage::getStoreConfig('dev/log/webgriffe_golive_active');
    }

    public function info()
    {
        $args = func_get_args();
        $formattedMsg = call_user_func_array('sprintf', $args);
        Mage::log($formattedMsg, Zend_Log::INFO, self::LOG_FILENAME, $this->_forceLog);
    }
}