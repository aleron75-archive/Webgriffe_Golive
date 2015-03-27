<?php
namespace Webgriffe\GoLive;

use N98\Magento\Command\System\Check\Result;
use N98\Magento\Command\System\Check\ResultCollection;
use N98\Magento\Command\System\Check\StoreCheck;
use N98\Magento\Command\System\CheckCommand;

class Mail implements StoreCheck
{
    /**
     * @param ResultCollection $results
     */
    public function check(ResultCollection $results, \Mage_Core_Model_Store $store)
    {
        $title = "Mail Settings - Disable Email Communications";
        $result = $results->createResult();
        $value = $store->getConfig('system/smtp/disable');
        if ('1' == $value) {
            $result->setStatus(Result::STATUS_WARNING);
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

        $title = "Mail Settings - Set Return Path";
        $result = $results->createResult();
        $value = $store->getConfig('system/smtp/set_return_path');
        if ('0' == $value) {
            $result->setStatus(Result::STATUS_WARNING);
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