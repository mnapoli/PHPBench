<?php
/**
 * @author  Matthieu Napoli
 * @license LGPL v3 (See LICENSE file)
 */

namespace PHPBench\BenchCase;

/**
 * This bench is intended to be run as a bench for calibration. The
 * execution time of a call to an empty bench will be substracted from
 * all the other benches.
 */
class DryRunBench extends \PHPBench\BenchCase
{

    /**
     * Number of iteration for the bench
     *
     * Set to a default value, will be overwritten
     * @var int
     */
    protected $_iterationNumber = 1;

    /**
     * Empty bench
     *
     * @return void
     */
    public function benchEmpty()
    {
    }

}
