<?php

class Webgriffe_Golive_Helper_Data extends Mage_Core_Helper_Abstract
{
   public function getVersion($len = null)
    {
        $ver = Mage::getConfig()->getNode('modules/Webgriffe_Golive/version');
        return $ver;
    }

}