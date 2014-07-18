<?php
class Webgriffe_Golive_Model_Checker_Design_RootFavicon
    extends Webgriffe_Golive_Model_Checker_File_Md5sum
{
    public function check($parameters = array())
    {
        $this->validateParameters($parameters);
        $this->setFilepath(Mage::getBaseDir().DS.'favicon.ico');
        return parent::check($parameters);
    }

}