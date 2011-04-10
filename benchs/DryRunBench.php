<?php
/**
 * @author Matthieu Napoli
 */

require_once __DIR__.'/../library/PHPBench/BenchCase.php';

/**
 * Dry run bench
 */
class DryRunBench extends \PHPBench\BenchCase
{

    /**
     * Run each bench 10000 times
     */
    protected $_iterationNumber = 100000;

    /**
     * Empty bench
     *
     * @return void
     */
    public function benchEmpty()
    {
    }

}
