<?php
namespace Webgriffe\GoLive;

use N98\Magento\Command\System\Check\Result;
use N98\Magento\Command\System\Check\ResultCollection;
use N98\Magento\Command\System\Check\StoreCheck;
use N98\Magento\Command\System\CheckCommand;

class ShippingOrigin implements StoreCheck
{
    /**
     * @param ResultCollection $results
     */
    public function check(ResultCollection $results, \Mage_Core_Model_Store $store)
    {
        $title = "Shipping Origin Country";
        $result = $results->createResult();
        $value = $store->getConfig('shipping/origin/country_id');
        if ('US' == $value) {
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

        $title = "Shipping Origin Region/State";
        $result = $results->createResult();
        $value = $store->getConfig('shipping/origin/region_id');
        if ('12' == $value) {
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

        $title = "Shipping Origin ZIP/Postal Code";
        $result = $results->createResult();
        $value = $store->getConfig('shipping/origin/postcode');
        if ('90034' == $value) {
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