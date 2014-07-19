<?php

class Webgriffe_Golive_Model_Checker_Design_ThemeLogoprint
    extends Webgriffe_Golive_Model_Checker_File_Md5sum
{
    public function check($parameters = array())
    {
        $this->validateParameters($parameters);
        $theme = $parameters['theme'];
        $this->setFilepath(Mage::getBaseDir('skin').DS.'frontend'.DS.$theme.DS.'images'.DS.'logo_print.gif');
        return parent::check($parameters);
    }

}