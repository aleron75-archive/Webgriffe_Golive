<?php
namespace Webgriffe\GoLive;

use N98\Magento\Command\System\Check\Result;
use N98\Magento\Command\System\Check\ResultCollection;
use N98\Magento\Command\System\Check\StoreCheck;
use N98\Magento\Command\System\CheckCommand;

class HtmlHeader implements StoreCheck
{
    /**
     * @param ResultCollection $results
     */
    public function check(ResultCollection $results, \Mage_Core_Model_Store $store)
    {
        $title = "Header Logo Image Alternate Text";
        $result = $results->createResult();
        $value = $store->getConfig('design/header/logo_alt');
        if ('Magento Commerce' == $value) {
            $result->setStatus(Result::STATUS_ERROR);
        } else {
            $result->setStatus(Result::STATUS_OK);
        }
        $msg = sprintf(
            "<info>%s of Store: <comment>%s</comment> %s - value is <comment>%s</comment></info>",
            $title,
            $store->getCode(),
            strtoupper($result->getStatus()),
            $value
        );
        $result->setMessage($msg);

        $title = "Header Welcome Text";
        $result = $results->createResult();
        $value = $store->getConfig('design/header/welcome');
        if ('Default welcome msg!' == $value) {
            $result->setStatus(Result::STATUS_ERROR);
        } else {
            $result->setStatus(Result::STATUS_OK);
        }
        $msg = sprintf(
            "<info>%s of Store: <comment>%s</comment> %s - value is <comment>%s</comment></info>",
            $title,
            $store->getCode(),
            strtoupper($result->getStatus()),
            $value
        );
        $result->setMessage($msg);
    }
}