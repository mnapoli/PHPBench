<?php
/**
 * @author Matthieu Napoli
 */

namespace PHPBench;

require_once 'BenchCase/DryRun.php';

/**
 * Bench runner
 */
class Runner
{

    /**
     * Run the bench case
     *
     * @param BenchCase $benchCase Bench case
     *
     * @return void
     */
    public function run(BenchCase $benchCase)
    {
        // Calibration
        $baseTime = $this->calibrate($benchCase->getIterationNumber());
        // Run the bench
        $results = $benchCase->run();
        // Render the results
        $this->displayResults($results, $baseTime);
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
     * @param array $results  Results
     * @param float $baseTime Base time of an empty bench
     *
     * @return void
     */
    protected function displayResults($results, $baseTime)
    {
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
        foreach ($results as $benchStep => $time) {
            if ($lowest > 0) {
                $percentage = number_format($time / $lowest * 100, 0);
            } else {
                $percentage = 100;
            }
            $time = number_format($time, 3);
            echo $benchStep.' : '.$time.' ms - '.$percentage.' %'.PHP_EOL;
        }
    }

}
