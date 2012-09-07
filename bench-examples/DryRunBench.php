<?php
/**
 * @author Matthieu Napoli
 */

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
