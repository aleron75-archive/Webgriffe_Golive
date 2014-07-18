<?php
require_once 'abstract.php';

class Mage_Shell_Webgriffe_Golive extends Mage_Shell_Abstract
{
    public function run()
    {
        $domain = $this->getArg('domain');

        if (empty($domain))
        {
            print $this->usageHelp();
            exit(1);
        }

        $parameters =     array(
            'domain'    => $domain,
        );

        $golive = new Webgriffe_Golive_Model_Core();

        printf("Active Checkers found: %d".PHP_EOL, $golive->getCheckersCount());
        printf("Checking current Magento installation... ");
        $result = $golive->check($parameters);
        printf("done!".PHP_EOL);

        $severityCount = array(
            Webgriffe_Golive_Model_Checker_Abstract::SEVERITY_NONE => 0,
            Webgriffe_Golive_Model_Checker_Abstract::SEVERITY_WARNING => 0,
            Webgriffe_Golive_Model_Checker_Abstract::SEVERITY_ERROR => 0
        );
        foreach ($result as $key => $val) {
            $severityCount[$val] ++;
        }

        printf("Errors: %d".PHP_EOL, $severityCount[Webgriffe_Golive_Model_Checker_Abstract::SEVERITY_ERROR]);
        printf("Warnings: %d".PHP_EOL, $severityCount[Webgriffe_Golive_Model_Checker_Abstract::SEVERITY_WARNING]);
        printf("Passed: %d".PHP_EOL, $severityCount[Webgriffe_Golive_Model_Checker_Abstract::SEVERITY_NONE]);


        Zend_Debug::dump($result, 'Detailed result');

        exit($severityCount[Webgriffe_Golive_Model_Checker_Abstract::SEVERITY_ERROR] > 0);
    }

    /**
     * Retrieve Usage Help Message
     *
     */
    public function usageHelp()
    {
        return <<<USAGE
Usage:  php -f golive.php -- [options]
        php -f golive.php --domain www.yourdomain.com

  --domain <domain> The domain against which this site configuration will be tested
  help              This help

USAGE;
    }

}

$shell = new Mage_Shell_Webgriffe_Golive();
$shell->run();
