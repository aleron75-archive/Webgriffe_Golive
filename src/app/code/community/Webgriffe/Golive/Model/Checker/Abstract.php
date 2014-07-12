<?php
abstract class Webgriffe_Golive_Model_Checker_Abstract extends Varien_Object
{
    const SEVERITY_ERROR    = 'error';
    const SEVERITY_WARNING  = 'warning';
    const SEVERITY_INFO     = 'info';

    /**
     * Initialize a Checker
     *
     * @param $name string
     * @param $description string
     * @param $severity string
     */
    public function initialize($name, $description, $severity)
    {
        $this->setName($name);
        $this->setDescription($description);
        $this->setSeverity($severity);
        return $this;
    }

    public abstract function check();
}