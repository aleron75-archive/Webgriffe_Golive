<?php
class Webgriffe_Golive_Model_Core
{
    const XML_CHECKERS_PATH = 'default/webgriffe_golive/checkers';

    private $_checkers = array();

    public function __construct($config = null)
    {
        if (is_null($config)) {
            $config = Mage::getConfig();
        }

        Mage::dispatchEvent('webgriffe_golive_core_construct_before', array('checkers'=>$this->_checkers));
        Varien_Profiler::start('webgriffe_golive::core::construct');
        $checkersConfig =  $config->getNode(self::XML_CHECKERS_PATH)->asArray();
        foreach ($checkersConfig as $checkerNodeName => $checkerNodeContent)
        {
            if (isset($checkerNodeContent['disabled']) && $checkerNodeContent['disabled']) {
                continue;
            }

            /** @var Webgriffe_Golive_Model_Checker_Abstract $checker */
            $checker = $this->_getCheckerInstance($checkerNodeName, $checkerNodeContent);
            $checker->initialize($checkerNodeName, $checkerNodeContent);
            $this->_checkers[$checkerNodeName] = $checker;
        }
        Varien_Profiler::stop('webgriffe_golive::core::construct');
        Mage::dispatchEvent('webgriffe_golive_core_construct_after', array('checkers'=>$this->_checkers));
    }

    /**
     * @param array $parameters Additional parameters
     */
    public function check($parameters = array())
    {
        $result = array();

        /** @var array $stores */
        $stores = Mage::app()->getStores();

        /** @var Mage_Core_Model_Store $store */
        foreach ($stores as $store)
        {
            $parameters['store_id'] = $store->getId();

            /** @var Webgriffe_Golive_Model_Checker_Abstract $checker */
            foreach ($this->_checkers as $checker)
            {
                $result[$checker->getCode()] = $checker->check($parameters);
            }
        }
        return $result;
    }

    public function getChecker($code)
    {
        if (isset($this->_checkers[$code])) {
            return $this->_checkers[$code];
        }
        return null;
    }

    protected function _getCheckerInstance($nodeName, $nodeContent)
    {
        if (!isset($nodeContent['name'])) {
            Mage::throwException(sprintf("Checker name not set for '%s'", $nodeName));
        }

        if (!isset($nodeContent['description'])) {
            Mage::throwException(sprintf("Checker description not set for '%s'", $nodeName));
        }

        if (!isset($nodeContent['default_severity'])) {
            Mage::throwException(sprintf("Checker severity not set for '%s'", $nodeName));
        }

        if (!isset($nodeContent['class'])) {
            Mage::throwException(sprintf("Checker class not set for '%s'", $nodeName));
        }

        $instance = Mage::getModel($nodeContent['class']);
        if ($instance === false) {
            Mage::throwException(sprintf("Checker class does not exist for '%s'", $nodeName));
        }

        return $instance;
    }

    public function getCheckersCount()
    {
        return count($this->_checkers);
    }
}