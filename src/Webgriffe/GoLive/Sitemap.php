<?php
namespace Webgriffe\GoLive;

use N98\Magento\Command\System\Check\Result;
use N98\Magento\Command\System\Check\ResultCollection;
use N98\Magento\Command\System\Check\StoreCheck;
use N98\Magento\Command\System\CheckCommand;

class Sitemap implements StoreCheck
{
    /**
     * @param ResultCollection $results
     */
    public function check(ResultCollection $results, \Mage_Core_Model_Store $store)
    {
        $title = "Sitemap";
        $result = $results->createResult();
        $count = \Mage::getModel('sitemap/sitemap')
            ->getCollection()
            ->addStoreFilter(array($store->getId()))
            ->getSize();
        if (!$count) {
            $result->setStatus(Result::STATUS_WARNING);
        } else {
            $result->setStatus(Result::STATUS_OK);
        }
        $msg = sprintf(
            "<info>%s of Store: <comment>%s</comment> %s - found <comment>%d</comment> items</info>",
            $title,
            $store->getCode(),
            strtoupper($result->getStatus()),
            $count
        );
        $result->setMessage($msg);
    }
}