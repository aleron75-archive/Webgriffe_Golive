<?php
namespace Webgriffe\GoLive;

use N98\Magento\Command\System\Check\Result;
use N98\Magento\Command\System\Check\ResultCollection;
use N98\Magento\Command\System\Check\SimpleCheck;

class Cache implements SimpleCheck
{
    /**
     * @param ResultCollection $results
     */
    public function check(ResultCollection $results)
    {
        $cacheTypes = \Mage::helper('core')->getCacheTypes();
        $enabledCaches = \Mage::app()->useCache();
        foreach ($cacheTypes as $cacheCode => $cacheName) {
            if ($enabledCaches[$cacheCode] == 0) {
                $results->createResult(Result::STATUS_WARNING, "<info>{$cacheName} cache WARNING - <comment>{$cacheCode}</comment> cache is disabled</info>");
            }
        }
    }
}