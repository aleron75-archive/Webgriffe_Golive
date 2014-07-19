<?php

class Webgriffe_Golive_Model_Checker_Design_ThemeLogo
    extends Webgriffe_Golive_Model_Checker_File_Md5sum
{
    public function check($parameters = array())
    {
        $this->validateParameters($parameters);
        $theme = $parameters['theme'];
        $this->setFilepath(Mage::getBaseDir('skin').DS.'frontend'.DS.$theme.DS.'images'.DS.'logo.gif');
        return parent::check($parameters);
    }

}