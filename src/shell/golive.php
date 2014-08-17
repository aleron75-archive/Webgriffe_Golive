<?php
require_once 'abstract.php';

class Mage_Shell_Webgriffe_Golive extends Mage_Shell_Abstract
{
    /**
     * @var Webgriffe_Golive_Model_Core The Go Live Core Object
     */
    private $_core = null;

    /**
     * @var Webgriffe_Golive_Helper_Output The Output Object
     */
    private $_out = null;
    
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
        $this->_out->printLine(sprintf("Webgriffe Go Live %s", Mage::helper('webgriffe_golive')->getVersion()));

        if ($this->_shouldExplain())
        {
            $this->_outputExplanation();
            exit(0);
        }

        $exitCode = $this->_outputCheckAndGetExitCode();
        exit($exitCode);
    }

    /**
     * Additional initialize instruction
     *
     * @return Mage_Shell_Abstract
     */
    protected function _construct()
    {
        parent::_construct();

        $this->_core = new Webgriffe_Golive_Model_Core();
        
        $this->_out = Mage::helper('webgriffe_golive/output');
        
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

        $domainPassed = true;
        if (!$this->getArg('domain') || $this->getArg('domain') === true)
        {
            $domainPassed = false;
        }

        $explainPassed = true;
        if (!$this->getArg('explain') || $this->getArg('explain') === true)
        {
            $explainPassed = false;
        }

        if (!$domainPassed && !$explainPassed)
        {
            exit ($this->usageHelp());
        }

        if (!$domainPassed && $explainPassed)
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

    /**
     * Contains logic which deterimnes whether an explain is needed
     *
     * @return int
     */
    protected function _shouldExplain()
    {
        return count($this->_explainIds);
    }

    /**
     * Output the explanation for all the requested Checker IDs
     */
    protected function _outputExplanation()
    {
        $this->_out->printLine();

        foreach ($this->_explainIds as $id) {
            if ($checker = $this->_core->getCheckerById($id)) {
                $name = $checker->getName();
                $description = $checker->getDescription();
                if (empty($description)) {
                    $description = '>>> Missing description for this checker';
                }
                $styles = array('-68');
                $this->_out->printTl($styles);
                $styles = array('3', '-62');
                $this->_out->printTr(
                    array($id, $name),
                    $styles,
                    $this->_useColors ? Webgriffe_Golive_Helper_Output::STYLE_BOLD : null
                );
                $styles = array('-68');
                $this->_out->printTl($styles);
                $this->_out->printTr(array($description), $styles);
            }
        }
        $this->_out->printTl($styles);
        $this->_out->printLine();
    }

    /**
     * @return array
     */
    protected function _outputCheckAndGetExitCode()
    {
        $this->_out->printLine(
            sprintf(
                "Active Checkers found: %d",
                $this->_core->getCheckersCount()
            )
        );
        $this->_out->printLine("Checking current Magento installation... ", 0);

        $parameters = array(
            'domain' => $this->getArg('domain'),
        );

        $result = $this->_core->check($parameters);

        $this->_out->printLine("done!", 2);

        $severityCount = array(
            Webgriffe_Golive_Model_Checker_Abstract::SEVERITY_SKIP => 0,
            Webgriffe_Golive_Model_Checker_Abstract::SEVERITY_NONE => 0,
            Webgriffe_Golive_Model_Checker_Abstract::SEVERITY_WARNING => 0,
            Webgriffe_Golive_Model_Checker_Abstract::SEVERITY_ERROR => 0
        );
        foreach ($result as $key => $val) {
            $severityCount[$val]++;
        }

        $styles = array('3', '-52', '-7');
        $this->_out->printTl($styles);
        $this->_out->printTr(
            array('ID', 'Checked', 'Result'),
            $styles,
            $this->_useColors ? Webgriffe_Golive_Helper_Output::STYLE_BOLD : null
        );
        $this->_out->printTl($styles);

        $id = 1;
        foreach ($result as $code => $res) {
            $checker = $this->_core->getChecker($code);
            $textStyle = null;
            if ($this->_useColors) {
                $textStyle = $this->_getTextStyleForResult($res);
            }
            $columns = array($id++, $checker->getName(), $res);
            $this->_out->printTr($columns, $styles, $textStyle);
        }

        $styles = array('58', '-7');
        $this->_out->printTl($styles);
        $this->_out->printTr(
            array(
                'Errors',
                $severityCount[Webgriffe_Golive_Model_Checker_Abstract::SEVERITY_ERROR]
            ),
            $styles
        );
        $this->_out->printTr(
            array(
                'Warnings',
                $severityCount[Webgriffe_Golive_Model_Checker_Abstract::SEVERITY_WARNING]
            ),
            $styles
        );
        $this->_out->printTr(
            array(
                'Passed',
                $severityCount[Webgriffe_Golive_Model_Checker_Abstract::SEVERITY_NONE]
            ),
            $styles
        );
        $this->_out->printTr(
            array(
                'Skipped',
                $severityCount[Webgriffe_Golive_Model_Checker_Abstract::SEVERITY_SKIP]
            ),
            $styles
        );
        $this->_out->printTl($styles);
        $this->_out->printLine();

        return $severityCount[Webgriffe_Golive_Model_Checker_Abstract::SEVERITY_ERROR];
    }

    /**
     * @param $res
     * @return int
     */
    protected function _getTextStyleForResult($res)
    {
        switch ($res) {
            case Webgriffe_Golive_Model_Checker_Abstract::SEVERITY_ERROR:
                $color = Webgriffe_Golive_Helper_Output::COLOR_RED;
                break;
            case Webgriffe_Golive_Model_Checker_Abstract::SEVERITY_WARNING:
                $color = Webgriffe_Golive_Helper_Output::COLOR_YELLOW;
                break;
            case Webgriffe_Golive_Model_Checker_Abstract::SEVERITY_SKIP:
                $color = Webgriffe_Golive_Helper_Output::COLOR_CYAN;
                break;
            default:
                $color = Webgriffe_Golive_Helper_Output::COLOR_DEFAULT;
                return $color;
        }
        return $color;
    }

}

$shell = new Mage_Shell_Webgriffe_Golive();
$shell->run();