<?php
/**
 * @author Matthieu Napoli
 */

namespace PHPBench;

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
        $results = $benchCase->run();
        // Render the results
        $this->displayResults($results);
    }

    /**
     * Display the results
     *
     * @param array $results Results
     *
     * @return void
     */
    protected function displayResults($results)
    {
        foreach ($results as $benchStep => $time) {
            echo $benchStep.' : '.$time.' ms'.PHP_EOL;
        }
    }

}
