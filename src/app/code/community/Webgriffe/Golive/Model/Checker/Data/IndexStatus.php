<?php
class Webgriffe_Golive_Model_Checker_Data_IndexStatus
    extends Webgriffe_Golive_Model_Checker_Abstract
{
    public function check($parameters = array())
    {
        $this->validateParameters($parameters);
        $processCode = $this->getProcessCode();
        $process = Mage::getSingleton('index/indexer')->getProcessByCode($processCode);

        if ($process->getStatus() != Mage_Index_Model_Process::STATUS_PENDING) {
            return $this->getDefaultSeverity();
        }

        return self::SEVERITY_NONE;
    }

}