<?php
namespace Webgriffe\GoLive;

use N98\Magento\Command\System\Check\Result;
use N98\Magento\Command\System\Check\ResultCollection;
use N98\Magento\Command\System\Check\StoreCheck;
use N98\Magento\Command\System\CheckCommand;

class TestData implements StoreCheck
{
    /**
     * @param ResultCollection $results
     */
    public function check(ResultCollection $results, \Mage_Core_Model_Store $store)
    {
        $entities = array(
            'Test Orders'               => array('type' => 'sales/order', 'filter_by_store' => 1),
            'Test Invoices'             => array('type' => 'sales/order_invoice', 'filter_by_store' => 1),
            'Test Test Shipments'       => array('type' => 'sales/order_shipment', 'filter_by_store' => 1),
            'Test Credimemos'           => array('type' => 'sales/order_creditmemo', 'filter_by_store' => 1),
            'Test Payments'             => array('type' => 'sales/order_payment', 'filter_by_store' => 0),
            'Test Transactions'         => array('type' => 'sales/order_payment_transaction', 'filter_by_store' => 0),
            'Test Customers'            => array('type' => 'customer/customer', 'filter_by_store' => 1),
            'Test Customer Addresses'   => array('type' => 'customer/address', 'filter_by_store' => 0),
        );

        foreach ($entities as $title => $entity) {
            $result = $results->createResult();
            $coll =  \Mage::getModel($entity['type'])->getCollection();
            if ($entity['filter_by_store']) {
                $coll->addFieldToFilter('store_id', $store->getId());
            }
            $count = $coll->getSize();
            if ($count) {
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
}