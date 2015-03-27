<?php
namespace Webgriffe\GoLive;

use N98\Magento\Command\System\Check\Result;
use N98\Magento\Command\System\Check\ResultCollection;
use N98\Magento\Command\System\Check\StoreCheck;
use N98\Magento\Command\System\CheckCommand;

class StoreEmail implements StoreCheck
{
    /**
     * @param ResultCollection $results
     */
    public function check(ResultCollection $results, \Mage_Core_Model_Store $store)
    {
        $title = "Store Email General Sender Name";
        $result = $results->createResult();
        $value = $store->getConfig('trans_email/ident_general/name');
        if ('Owner' == $value) {
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

        $title = "Store Email General Sender Address";
        $result = $results->createResult();
        $value = $store->getConfig('trans_email/ident_general/email');
        if ('owner@example.com' == $value) {
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

        $title = "Store Email Sales Representative Sender Name";
        $result = $results->createResult();
        $value = $store->getConfig('trans_email/ident_sales/name');
        if ('Sales' == $value) {
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

        $title = "Store Email Sales Representative Sender Address";
        $result = $results->createResult();
        $value = $store->getConfig('trans_email/ident_sales/email');
        if ('sales@example.com' == $value) {
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

        $title = "Store Email Customer Support Sender Name";
        $result = $results->createResult();
        $value = $store->getConfig('trans_email/ident_support/name');
        if ('CustomerSupport' == $value) {
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

        $title = "Store Email Customer Support Sender Address";
        $result = $results->createResult();
        $value = $store->getConfig('trans_email/ident_support/email');
        if ('support@example.com' == $value) {
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

        $title = "Store Email Custom Email 1 Sender Name";
        $result = $results->createResult();
        $value = $store->getConfig('trans_email/ident_custom1/name');
        if ('Custom 1' == $value) {
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

        $title = "Store Email Custom Email 1 Sender Address";
        $result = $results->createResult();
        $value = $store->getConfig('trans_email/ident_custom1/email');
        if ('custom1@example.com' == $value) {
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

        $title = "Store Email Custom Email 2 Sender Name";
        $result = $results->createResult();
        $value = $store->getConfig('trans_email/ident_custom2/name');
        if ('Custom 2' == $value) {
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

        $title = "Store Email Custom Email 2 Sender Address";
        $result = $results->createResult();
        $value = $store->getConfig('trans_email/ident_custom2/email');
        if ('custom2@example.com' == $value) {
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