<?php
namespace Webgriffe\GoLive;

use N98\Magento\Command\System\Check\Result;
use N98\Magento\Command\System\Check\ResultCollection;
use N98\Magento\Command\System\Check\SimpleCheck;

class Index implements SimpleCheck
{
    /**
     * @param ResultCollection $results
     */
    public function check(ResultCollection $results)
    {
        $processes = array(
            'Catalog Product Attribute Index'   => 'catalog_product_attribute',
            'Catalog Product Price Index'       => 'catalog_product_price',
            'Catalog URL Index'                 => 'catalog_url',
            'Catalog Product Flat Index'        => 'catalog_product_flat',
            'Catalog Category Flat Index'       => 'catalog_category_flat',
            'Catalog Category Product Index'    => 'catalog_category_product',
            'Catalog Search Fulltext Index'     => 'catalogsearch_fulltext',
            'Catalog Inventory Stock Index'     => 'cataloginventory_stock',
            'Tag Summary Index'                 => 'tag_summary',
        );

        foreach ($processes as $title => $processCode) {
            $result = $results->createResult();

            $process = \Mage::getSingleton('index/indexer')->getProcessByCode($processCode);
            if (!$process) {
                continue;
            }
            if ($process->getStatus() != \Mage_Index_Model_Process::STATUS_PENDING) {
                $result->setStatus(Result::STATUS_WARNING);
            } else {
                $result->setStatus(Result::STATUS_OK);
            }
            $msg = sprintf(
                "<info>%s (<comment>%s</comment>) %s - value is <comment>%s</comment></info>",
                $title,
                $processCode,
                strtoupper($result->getStatus()),
                $process->getStatus()
            );
            $result->setMessage($msg);

        }
    }
}