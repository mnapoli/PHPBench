<?php
/**
 * @author  Matthieu Napoli
 * @license LGPL v3 (See LICENSE file)
 */

namespace PHPBench;

require_once 'BenchCase/DryRun.php';

/**
 * Bench runner
 */
class Runner
{

    /**
     * Bench cases to run
     * @var array(BenchCase)
     */
    protected $_benchCases = array();

	/**
	 * If true, the bench results will be written to file
	 * @var bool
	 */
	private $_logToFile = false;

    /**
     * Add a bench case to the run list
     *
     * @param BenchCase $benchCase Bench case
     *
     * @return void
     */
    public function addBenchCase(BenchCase $benchCase)
    {
        $this->_benchCases[] = $benchCase;
    }

    /**
     * Add a bench suite to the run list
     *
     * @param BenchSuite $benchSuite Bench suite
     *
     * @return void
     */
    public function addBenchSuite(BenchSuite $benchSuite)
    {
        $benchCases = $benchSuite->getBenchCases();
        foreach ($benchCases as $benchCase) {
            $this->_benchCases[] = $benchCase;
        }
    }

    /**
     * Run the bench case
     *
     * @param BenchSuite $benchSuite Bench suite to run immediatly
     *
     * @return void
     */
    public function run(BenchSuite $benchSuite = null)
    {
        if ($benchSuite !== null) {
            $this->addBenchSuite($benchSuite);
        }
        echo 'PHPBench - https://github.com/mnapoli/PHPBench - Matthieu Napoli'
            .' - LGPL v3'.PHP_EOL.PHP_EOL;
        foreach ($this->_benchCases as $benchCase) {
			/** @var $benchCase BenchCase */
            // Calibration
            $baseTime = $this->calibrate($benchCase->getIterationNumber());
            // Run the bench
            $results = $benchCase->run();
            // Render the results
            $this->displayResults($benchSuite, $benchCase, $results, $baseTime);
        }
    }

    /**
     * Calibrate the bench
     *
     * Run an empty test
     *
     * @param int $iterationNumber Number of iteration
     *
     * @return float Execution time of an empty bench
     */
    public function calibrate($iterationNumber)
    {
        $benchCase = new BenchCase\DryRunBench();
        $benchCase->setIterationNumber($iterationNumber);
        $results = $benchCase->run();
        return array_pop($results);
    }

    /**
     * Display the results
     *
	 * @param BenchSuite $benchSuite Bench suite
	 * @param BenchCase  $benchCase Bench case
     * @param array      $results   Results
     * @param float      $baseTime  Base time of an empty bench
     *
     * @return void
     */
    protected function displayResults($benchSuite, $benchCase, $results, $baseTime)
    {
		$fileContent = 'PHPBench - https://github.com/mnapoli/PHPBench - Matthieu Napoli'
			.' - LGPL v3'.PHP_EOL.PHP_EOL;
        // Substract the base time
        foreach ($results as $benchStep => $time) {
            $results[$benchStep] -= $baseTime;
            if ($results[$benchStep] < 0) {
                $results[$benchStep] = 0.;
            }
        }
        // Find the lowest time
        $lowest = null;
        foreach ($results as $benchStep => $time) {
            if (($lowest === null) || ($lowest > $time)) {
                $lowest = $time;
            }
        }
        // Display
        echo 'Bench case : '.get_class($benchCase).PHP_EOL;
		if ($this->_logToFile) {
			$fileContent .= 'Bench case : '.get_class($benchCase).PHP_EOL;
		}
        foreach ($results as $benchStep => $time) {
            if ($lowest > 0) {
                $percentage = number_format($time / $lowest * 100, 0);
            } else {
                $percentage = 100;
            }
            $time = number_format($time, 3);
            $benchName = str_replace('bench', '', $benchStep);
            echo '    '.$benchName.' : '.$time.' s - '.$percentage.' %'.PHP_EOL;
			if ($this->_logToFile) {
				$fileContent .= '    '.$benchName.' : '.$time.' s - '.$percentage.' %'.PHP_EOL;
			}
        }
		if ($this->_logToFile) {
			file_put_contents($benchSuite->getPath().'/'.get_class($benchCase).'-results.log', $fileContent);
		}
    }

	/**
	 * Enable logging the bench results to file
	 * @param $bool
	 */
	public function enableLogToFile($bool)
	{
		$this->_logToFile = $bool;
	}

}
