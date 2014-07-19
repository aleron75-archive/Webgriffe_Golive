<?php
class Webgriffe_Golive_Model_Checker_Data_EmptyEntityCollection
    extends Webgriffe_Golive_Model_Checker_Abstract
{
    public function check($parameters = array())
    {
        $this->validateParameters($parameters);
        $entityType = $this->getEntityType();
        $itemCount = Mage::getModel($entityType)->getCollection()->getSize();

        if ($itemCount > 0) {
            return $this->getDefaultSeverity();
        }

        return self::SEVERITY_NONE;
    }
}