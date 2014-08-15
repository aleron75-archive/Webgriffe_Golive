<?php
require_once 'abstract.php';

class Mage_Shell_Webgriffe_Golive extends Mage_Shell_Abstract
{
    /**
     * @var bool Indicates whether to use colors or not.
     */
    private $_useColors = true;

    /**
     * @var array Contains the list of Checkers ID to explain
     */
    private $_explainIds = array();

    public function run()
    {
        $out = Mage::helper('webgriffe_golive/output');

        $golive = new Webgriffe_Golive_Model_Core();

        $out->printLine(sprintf("Webgriffe Go Live %s", Mage::helper('webgriffe_golive')->getVersion()));

        if (count($this->_explainIds))
        {
            $out->printLine();

            foreach ($this->_explainIds as $id)
            {
                if ($checker = $golive->getCheckerById($id))
                {
                    $description = $checker->getDescription();
                    if (empty($description)) {
                        $description = '>>> Missing description for this checker';
                    }
                    $out->printLine(sprintf("%s: %s\n%s\n---", $id, $checker->getName(), $description));
                }
            }

            exit(0);
        }

        $out->printLine(sprintf("Active Checkers found: %d", $golive->getCheckersCount()));
        $out->printLine("Checking current Magento installation... ", 0);

        $parameters =     array(
            'domain'    => $this->getArg('domain'),
        );

        $result = $golive->check($parameters);

        $out->printLine("done!", 2);

        $severityCount = array(
            Webgriffe_Golive_Model_Checker_Abstract::SEVERITY_SKIP => 0,
            Webgriffe_Golive_Model_Checker_Abstract::SEVERITY_NONE => 0,
            Webgriffe_Golive_Model_Checker_Abstract::SEVERITY_WARNING => 0,
            Webgriffe_Golive_Model_Checker_Abstract::SEVERITY_ERROR => 0
        );
        $maxlen = 0;
        foreach ($result as $key => $val) {
            $severityCount[$val] ++;
            $checker = $golive->getChecker($key);
            $maxlen = max($maxlen, strlen($checker->getName()));
        }

        $mask = "| %3s | %-".$maxlen."s | %-7s |";
        $out->printLine(sprintf($mask, str_repeat('-', 3), str_repeat('-', $maxlen), str_repeat('-', 7)));
        $out->printLine(sprintf($mask, 'ID', 'Checked', 'Result'));
        $out->printLine(sprintf($mask, str_repeat('-', 3), str_repeat('-', $maxlen), str_repeat('-', 7)));
        $id = 1;
        foreach ($result as $code => $res) {
            $checker = $golive->getChecker($code);
            if ($this->_useColors) {
                switch ($res) {
                    case Webgriffe_Golive_Model_Checker_Abstract::SEVERITY_ERROR:
                        $mask = "| %3s | \033[31m%-".$maxlen."s\033[0m | \033[31m%-7s\033[0m |\n";
                        break;
                    case Webgriffe_Golive_Model_Checker_Abstract::SEVERITY_WARNING:
                        $mask = "| %3s | \033[33m%-".$maxlen."s\033[0m | \033[33m%-7s\033[0m |\n";
                        break;
                    case Webgriffe_Golive_Model_Checker_Abstract::SEVERITY_SKIP:
                        $mask = "| %3s | \033[36m%-".$maxlen."s\033[0m | \033[36m%-7s\033[0m |\n";
                        break;
                    default:
                        $mask = "| %3s | %-".$maxlen."s | %-7s |\n";
                }
            }
            $out->printLine(sprintf($mask, $id++, $checker->getName(), $res), 0);
        }
        $mask = "| %".($maxlen+6)."s | %-7s |";
        $out->printLine(sprintf($mask, str_repeat('-', $maxlen+6), str_repeat('-', 7)));
        $out->printLine(sprintf($mask, "Errors", $severityCount[Webgriffe_Golive_Model_Checker_Abstract::SEVERITY_ERROR]));
        $out->printLine(sprintf($mask, "Warnings", $severityCount[Webgriffe_Golive_Model_Checker_Abstract::SEVERITY_WARNING]));
        $out->printLine(sprintf($mask, "Passed", $severityCount[Webgriffe_Golive_Model_Checker_Abstract::SEVERITY_NONE]));
        $out->printLine(sprintf($mask, "Skipped", $severityCount[Webgriffe_Golive_Model_Checker_Abstract::SEVERITY_SKIP]));
        $out->printLine(sprintf($mask, str_repeat('-', $maxlen+6), str_repeat('-', 7)));
        $out->printLine();
        exit($severityCount[Webgriffe_Golive_Model_Checker_Abstract::SEVERITY_ERROR]);
    }

    /**
     * Additional initialize instruction
     *
     * @return Mage_Shell_Abstract
     */
    protected function _construct()
    {
        parent::_construct();

        if (isset($this->_args['nocolors']))
        {
            $this->_useColors = false;
        }

        return $this;
    }

    /**
     * Validate arguments
     *
     */
    protected function _validate()
    {
        parent::_validate();

        if (!isset($this->_args['domain']) && !isset($this->_args['explain']))
        {
            exit ($this->usageHelp());
        }

        if (isset($this->_args['explain']))
        {
            $this->_explainIds = array_map("trim", explode(',', $this->_args['explain']));
            asort($this->_explainIds);
        }
    }

    /**
     * Retrieve Usage Help Message
     *
     */
    public function usageHelp()
    {
        $version = Mage::helper('webgriffe_golive')->getVersion();
        return <<<USAGE
Webgriffe Go Live v $version
Usage:  php -f golive.php --[option] --[option <option_value>]
        php -f golive.php --domain www.yourdomain.com

  --domain <domain> The domain against which this site configuration will be tested
  --explain <ids>   The list of comma separated IDs whose description has to be printed
  --nocolors        Don't use colors (useful when directing output to file)
  -h, --help        This help

USAGE;
    }

}

$shell = new Mage_Shell_Webgriffe_Golive();
$shell->run();
