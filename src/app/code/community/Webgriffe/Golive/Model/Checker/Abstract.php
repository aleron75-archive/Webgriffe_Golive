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

    public function validateParameters(&$parameters)
    {
        if (!isset($parameters['store_id'])) {
            $parameters['store_id'] = null;
        }
    }
}