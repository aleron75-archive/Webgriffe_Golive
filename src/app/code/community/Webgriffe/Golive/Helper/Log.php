<?php

class Webgriffe_Golive_Helper_Log extends Mage_Core_Helper_Abstract
{
    const LOG_FILENAME = 'Webgriffe_golive.log';

    private $_forceLog;

    public function __construct()
    {
        $this->_forceLog = $forceLog = Mage::getStoreConfig(
            'dev/log/webgriffe_golive_active'
        );
    }

    public function info()
    {
        $args = func_get_args();
        $formattedMsg = call_user_func_array('sprintf', $args);
        $backtrace = debug_backtrace();
        if (count($backtrace) > 1) {
            array_shift($backtrace);
        }
        $msg = sprintf(
            '[%s->%s()] %s',
            $backtrace[0]['class'],
            $backtrace[0]['function'],
            $formattedMsg
        );
        Mage::log($msg, Zend_Log::INFO, self::LOG_FILENAME, $this->_forceLog);
    }

    public function error()
    {
        $args = func_get_args();
        $formattedMsg = call_user_func_array('sprintf', $args);
        $backtrace = debug_backtrace();
        if (count($backtrace) > 1) {
            array_shift($backtrace);
        }
        $msg = sprintf(
            '[%s->%s()] %s',
            $backtrace[0]['class'],
            $backtrace[0]['function'],
            $formattedMsg
        );
        Mage::log($msg, Zend_Log::ERR, self::LOG_FILENAME, $this->_forceLog);
    }
}