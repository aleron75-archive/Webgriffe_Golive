<?php
namespace Webgriffe\GoLive;

use N98\Magento\Command\System\Check\Result;
use N98\Magento\Command\System\Check\ResultCollection;
use N98\Magento\Command\System\Check\StoreCheck;
use N98\Magento\Command\System\CheckCommand;

class ImagePlaceholder implements StoreCheck
{
    /**
     * Values calculated on Magento v 1.8.1.0;
     * it's recommended to update value on different version.
     * To obtain the md5sum of a file, run the command:
     * $ md5sum <filename>
     */
    const IMAGE_PLACEHOLDER         = '097ab8a3051bc037ea3de0e17f440540';
    const SMALL_IMAGE_PLACEHOLDER   = 'f825d16f97a640453553c79c48ebaa73';
    const THUMBNAIL_PLACEHOLDER     = 'b2b682d28a08a748a73d2cda70ab5a57';

    /**
     * @param ResultCollection $results
     */
    public function check(ResultCollection $results, \Mage_Core_Model_Store $store)
    {
        $checks = array(
            'Image Placeholder' => array('filename' => 'image.jpg', 'md5' => self::IMAGE_PLACEHOLDER),
            'Small Image Placeholder' => array('filename' => 'small_image.jpg', 'md5' => self::SMALL_IMAGE_PLACEHOLDER),
            'Thumbnail Placeholder' => array('filename' => 'thumbnail.jpg', 'md5' => self::THUMBNAIL_PLACEHOLDER),
        );

        $theme = $this->_getTheme($store);
        foreach ($checks as $title => $values) {
            $result = $results->createResult();
            $realpath = 'frontend'.DS.$theme.DS.'images'.DS.'catalog'.DS.'product'.DS.'placeholder'.DS.$values['filename'];
            $placeholderfile = \Mage::getBaseDir('skin').DS.$realpath;
            if (!file_exists($placeholderfile)) {
                $result->setStatus(Result::STATUS_WARNING);
                $value = 'missing';
            } elseif (md5_file($placeholderfile) == $values['md5']) {
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