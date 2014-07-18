<?php
abstract class Webgriffe_Golive_Model_Checker_Abstract extends Varien_Object
{
    const SEVERITY_ERROR    = 'error';
    const SEVERITY_WARNING  = 'warning';
    const SEVERITY_NONE     = 'passed';

    /** @var  Webgriffe_Golive_Helper_Log */
    protected $_logger;

    public function __construct()
    {
        parent::__construct();
        $this->_logger = Mage::helper('webgriffe_golive/log');
    }

    /**
     * Initialize a Checker
     *
     *
    $checkerNodeContent['name'],
    $checkerNodeContent['description'],
    $checkerNodeContent['severity']
     *
     */
    public function initialize($code, $data)
    {
        $this->setCode($code);
        $this->addData(array_map("trim", $data));
        return $this;
    }

    public abstract function check($parameters = array());

    /**
     * @param $parameters
     */
    public function validateParameters(&$parameters)
    {
        // If store_id is not passed, null is assumed to be used
        if (!isset($parameters['store_id'])) {
            $parameters['store_id'] = null;
        }

        // If theme is not passed as parameter, it's taken from configuration.
        // If not configured, fallback to <default package/default theme>.
        if (!isset($parameters['theme']))
        {
            $package = Mage::getStoreConfig('design/package/name', $parameters['store_id']);
            if (empty($package)) {
                $package = Mage_Core_Model_Design_Package::DEFAULT_PACKAGE;
            }

            $theme = Mage::getStoreConfig('design/theme/default', $parameters['store_id']);
            if (empty($theme)) {
                $theme = Mage_Core_Model_Design_Package::DEFAULT_THEME;
            }

            $parameters['theme'] = $package.DS.$theme;
        }
    }
}