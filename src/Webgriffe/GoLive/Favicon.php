<?php
namespace Webgriffe\GoLive;

use N98\Magento\Command\System\Check\Result;
use N98\Magento\Command\System\Check\ResultCollection;
use N98\Magento\Command\System\Check\StoreCheck;
use N98\Magento\Command\System\CheckCommand;

class Favicon implements StoreCheck
{
    /**
     * Value calculated on Magento v 1.8.1.0;
     * it's recommended to update value on different version.
     * To obtain the md5sum of a file, run the command:
     * $ md5sum <filename>
     */
    const MAGE_FAVICON_MD5 = '88733ee53676a47fc354a61c32516e82';

    /**
     * @param ResultCollection $results
     */
    public function check(ResultCollection $results, \Mage_Core_Model_Store $store)
    {
        $title = "Root Favicon";
        $result = $results->createResult();
        $realpath = 'favicon.ico';
        $faviconfile = \Mage::getBaseDir('base').DS.$realpath;
        if (!file_exists($faviconfile)) {
            $result->setStatus(Result::STATUS_WARNING);
            $value = 'missing';
        } elseif (md5_file($faviconfile) == self::MAGE_FAVICON_MD5) {
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
            $realpath,
            $value
        );
        $result->setMessage($msg);

        $title = "Theme Favicon";
        $result = $results->createResult();
        $theme = $this->_getTheme($store);
        $realpath = 'frontend'.DS.$theme.DS.'favicon.ico';
        $faviconfile = \Mage::getBaseDir('skin').DS.$realpath;
        if (!file_exists($faviconfile)) {
            $result->setStatus(Result::STATUS_WARNING);
            $value = 'missing';
        } elseif (md5_file($faviconfile) == self::MAGE_FAVICON_MD5) {
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
