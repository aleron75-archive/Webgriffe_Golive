<?php
abstract class Webgriffe_Golive_Model_Checker_File_Md5sum
    extends Webgriffe_Golive_Model_Checker_Abstract
{
    public function check($parameters = array())
    {
        $this->validateParameters($parameters);

        $filepath = $this->getFilepath();

        if (file_exists($filepath)
            && md5_file($filepath) == $this->getMd5sum()
        ) {
            return $this->getDefaultSeverity();
        }

        return self::SEVERITY_NONE;
    }

}