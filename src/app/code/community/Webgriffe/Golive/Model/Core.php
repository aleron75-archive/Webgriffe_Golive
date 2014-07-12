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
            $checker->initialize(
                $checkerNodeContent['name'],
                $checkerNodeContent['description'],
                $checkerNodeContent['severity']
            );
            $this->_checkers[$checkerNodeName] = $checker;
        }
        Varien_Profiler::stop('webgriffe_golive::core::construct');
        Mage::dispatchEvent('webgriffe_golive_core_construct_after', array('checkers'=>$this->_checkers));
    }

    public function check()
    {
        $result = array();

        /** @var Webgriffe_Golive_Model_Checker_Abstract $checker */
        foreach ($this->_checkers as $checker)
        {
            $result = $checker->check();
        }
    }

    protected function _getCheckerInstance($nodeName, $nodeContent)
    {
        if (!isset($nodeContent['name'])) {
            Mage::throwException(sprintf("Checker name not set for '%s'", $nodeName));
        }

        if (!isset($nodeContent['description'])) {
            Mage::throwException(sprintf("Checker description not set for '%s'", $nodeName));
        }

        if (!isset($nodeContent['severity'])) {
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
}