<?php

class Webgriffe_Golive_Model_Checker_Design_SmallimagePlaceholder
    extends Webgriffe_Golive_Model_Checker_File_Md5sum
{
    public function check($parameters = array())
    {
        $this->validateParameters($parameters);
        $theme = $parameters['theme'];
        $this->setFilepath(Mage::getBaseDir('skin').DS.'frontend'.DS.$theme.DS.'images'.DS.'catalog'.DS.'product'.DS.'placeholder'.DS.'small_image.jpg');
        return parent::check($parameters);
    }

}