<?php
namespace Webgriffe\GoLive;

use N98\Magento\Command\System\Check\Result;
use N98\Magento\Command\System\Check\ResultCollection;
use N98\Magento\Command\System\Check\StoreCheck;
use N98\Magento\Command\System\CheckCommand;

class HtmlHead implements StoreCheck
{
    /**
     * @param ResultCollection $results
     */
    public function check(ResultCollection $results, \Mage_Core_Model_Store $store)
    {
        $title = "HTML Head Default Title";
        $result = $results->createResult();
        $value = $store->getConfig('design/head/default_title');
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

        $title = "HTML Head Default Description";
        $result = $results->createResult();
        $value = $store->getConfig('design/head/default_description');
        if ('Default Description' == $value) {
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

        $title = "HTML Head Default Keywords";
        $result = $results->createResult();
        $value = $store->getConfig('design/head/default_keywords');
        if ('Magento, Varien, E-commerce' == $value) {
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

        $title = "HTML Head Default Robots";
        $result = $results->createResult();
        $value = $store->getConfig('design/head/default_robots');
        if ('INDEX,FOLLOW' != $value) {
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

        $title = "HTML Head Demo Notice";
        $result = $results->createResult();
        $value = $store->getConfig('design/head/demonotice');
        if ($value) {
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