<?php
namespace Webgriffe\GoLive;

use N98\Magento\Command\System\Check\Result;
use N98\Magento\Command\System\Check\ResultCollection;
use N98\Magento\Command\System\Check\StoreCheck;
use N98\Magento\Command\System\CheckCommand;

class StoreInformation implements StoreCheck
{
    public function check(ResultCollection $results, \Mage_Core_Model_Store $store)
    {
        $checks = array(
            'Store Name'            => 'general/store_information/name',
            'Store Phone'           => 'general/store_information/phone',
            'Country'               => 'general/store_information/merchant_country',
            'VAT Number'            => 'general/store_information/merchant_vat_number',
            'Store Contact Address' => 'general/store_information/address',
        );

        foreach ($checks as $title => $configNode) {
            $result = $results->createResult();
            $value = $store->getConfig($configNode);
            if (empty($value)) {
                $result->setStatus(Result::STATUS_WARNING);
            } else {
                $result->setStatus(Result::STATUS_OK);
            }
            $msg = sprintf(
                "<info>%s of Store: <comment>%s</comment> %s - value is <comment>%s</comment></info>",
                'Store Information - ' . $title,
                $store->getCode(),
                strtoupper($result->getStatus()),
                $value
            );
            $result->setMessage($msg);
        }
    }
}