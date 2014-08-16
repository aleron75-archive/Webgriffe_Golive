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
                    $name = $checker->getName();
                    $description = $checker->getDescription();
                    if (empty($description)) {
                        $description = '>>> Missing description for this checker';
                    }
                    $styles = array('-68');
                    $out->printTl($styles);
                    $styles = array('3', '-62');
                    $out->printTr(array($id, $name), $styles, $this->_useColors ? $out::STYLE_BOLD : '');
                    $styles = array('-68');
                    $out->printTl($styles);
                    $out->printTr(array($description), $styles);
                }
            }
            $out->printTl($styles);
            $out->printLine();

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


        $styles = array('3', '-52', '-7');
        $out->printTl($styles);
        $out->printTr(array('ID', 'Checked', 'Result'), $styles, $out::STYLE_BOLD);
        $out->printTl($styles);

        $id = 1;
        foreach ($result as $code => $res) {
            $checker = $golive->getChecker($code);
            if ($this->_useColors) {
                switch ($res) {
                    case Webgriffe_Golive_Model_Checker_Abstract::SEVERITY_ERROR:
                        $color = $out::COLOR_RED;
                        break;
                    case Webgriffe_Golive_Model_Checker_Abstract::SEVERITY_WARNING:
                        $color = $out::COLOR_YELLOW;
                        break;
                    case Webgriffe_Golive_Model_Checker_Abstract::SEVERITY_SKIP:
                        $color = $out::COLOR_CYAN;
                        break;
                    default:
                        $color = $out::COLOR_DEFAULT;
                }
            }
            $columns = array($id ++, $checker->getName(), $res);
            $out->printTr($columns, $styles, $color);
        }

        $styles = array('58', '-7');
        $out->printTl($styles);
        $out->printTr(array('Errors', $severityCount[Webgriffe_Golive_Model_Checker_Abstract::SEVERITY_ERROR]), $styles);
        $out->printTr(array('Warnings', $severityCount[Webgriffe_Golive_Model_Checker_Abstract::SEVERITY_WARNING]), $styles);
        $out->printTr(array('Passed', $severityCount[Webgriffe_Golive_Model_Checker_Abstract::SEVERITY_NONE]), $styles);
        $out->printTr(array('Skipped', $severityCount[Webgriffe_Golive_Model_Checker_Abstract::SEVERITY_SKIP]), $styles);
        $out->printTl($styles);
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