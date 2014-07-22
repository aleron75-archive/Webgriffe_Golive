<?php
class Webgriffe_Golive_Model_Checker_Data_EntityCollection
    extends Webgriffe_Golive_Model_Checker_Abstract
{
    public function check($parameters = array())
    {
        $this->validateParameters($parameters);
        $entityType = $this->getEntityType();
        $itemCount = Mage::getModel($entityType)->getCollection()->getSize();
        $count = $this->getCount();

        switch ($this->getFaultOperand())
        {
            case 'neq':
                $result = ($itemCount != $count);
                break;
            case 'eq':
                // break intentionally omitted: 'eq' is default fault operand
            default:
                $result = ($itemCount == $count);
        }

        if ($result) {
            return $this->getDefaultSeverity();
        }

        return self::SEVERITY_NONE;
    }
}