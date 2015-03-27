<?php
namespace Webgriffe\GoLive;

use N98\Magento\Command\System\Check\Result;
use N98\Magento\Command\System\Check\ResultCollection;
use N98\Magento\Command\System\Check\StoreCheck;
use N98\Magento\Command\System\CheckCommand;

class Theme implements StoreCheck
{
    /**
     * Value calculated on Magento v 1.8.1.0;
     * it's recommended to update value on different version.
     * To obtain the md5sum of a file, run the command:
     * $ md5sum <filename>
     */
    const LOGO_MD5 = '48b7eb03807fdf80bdfb19b872cf84b8';

    /**
     * @param ResultCollection $results
     */
    public function check(ResultCollection $results, \Mage_Core_Model_Store $store)
    {
        $title = "Current Theme Logo";
        $result = $results->createResult();
        $theme = $this->_getTheme($store);
        $realpath = 'frontend'.DS.$theme.DS.'images'.DS.'logo.gif';
        $logofile = \Mage::getBaseDir('skin').DS.$realpath;
        if (!file_exists($logofile)) {
            $result->setStatus(Result::STATUS_WARNING);
            $value = 'missing';
        } elseif (md5_file($logofile) == self::LOGO_MD5) {
            $result->setStatus(Result::STATUS_WARNING);
            $value = 'default';
        } else {
            $result->setStatus(Result::STATUS_OK);
            $value = 'changed from default';
        }
        $msg = sprintf(
            "<info>%s of Store: <comment>%s</comment> %s - %s file is <comment>%s</comment></info>",
            $title,
            $store->getCode(),
            strtoupper($result->getStatus()),
            'skin'.DS.$realpath,
            $value
        );
        $result->setMessage($msg);

        $title = "Current Theme Logo Email";
        $result = $results->createResult();
        $theme = $this->_getTheme($store);
        $realpath = 'frontend'.DS.$theme.DS.'images'.DS.'logo_email.gif';
        $logofile = \Mage::getBaseDir('skin').DS.$realpath;
        if (!file_exists($logofile)) {
            $result->setStatus(Result::STATUS_WARNING);
            $value = 'missing';
        } elseif (md5_file($logofile) == self::LOGO_MD5) {
            $result->setStatus(Result::STATUS_WARNING);
            $value = 'default';
        } else {
            $result->setStatus(Result::STATUS_OK);
            $value = 'changed from default';
        }
        $msg = sprintf(
            "<info>%s of Store: <comment>%s</comment> %s - %s file is <comment>%s</comment></info>",
            $title,
            $store->getCode(),
            strtoupper($result->getStatus()),
            'skin'.DS.$realpath,
            $value
        );
        $result->setMessage($msg);

        $title = "Current Theme Logo Print";
        $result = $results->createResult();
        $theme = $this->_getTheme($store);
        $realpath = 'frontend'.DS.$theme.DS.'images'.DS.'logo_print.gif';
        $logofile = \Mage::getBaseDir('skin').DS.$realpath;
        if (!file_exists($logofile)) {
            $result->setStatus(Result::STATUS_WARNING);
            $value = 'missing';
        } elseif (md5_file($logofile) == self::LOGO_MD5) {
            $result->setStatus(Result::STATUS_WARNING);
            $value = 'default';
        } else {
            $result->setStatus(Result::STATUS_OK);
            $value = 'changed from default';
        }
        $msg = sprintf(
            "<info>%s of Store: <comment>%s</comment> %s - %s file is <comment>%s</comment></info>",
            $title,
            $store->getCode(),
            strtoupper($result->getStatus()),
            'skin'.DS.$realpath,
            $value
        );
        $result->setMessage($msg);
    }

    /**
     * @param \Mage_Core_Model_Store $store
     */
    private function _getTheme(\Mage_Core_Model_Store $store)
    {
        $package = $store->getConfig('design/package/name');
        if (empty($package)) {
            $package = \Mage_Core_Model_Design_Package::DEFAULT_PACKAGE;
        }
        $theme = $store->getConfig('design/theme/default');
        if (empty($theme)) {
            $theme = \Mage_Core_Model_Design_Package::DEFAULT_THEME;
        }
        return $package . DS . $theme;
    }
}