<?php
/**
 * @author Matthieu Napoli
 */

require_once __DIR__.'/../library/PHPBench/BenchSuite.php';
require_once __DIR__.'/../library/PHPBench/Runner.php';

/**
 * Bench suite
 */
class BenchSuite extends \PHPBench\BenchSuite
{

    protected $_path = __DIR__;

}

$benchRunner = new \PHPBench\Runner();
$benchRunner->run(new BenchSuite());
