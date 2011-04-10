<?php
/**
 * @author Matthieu Napoli
 */

namespace Benchs;

require_once __DIR__.'/../library/PHPBench/BenchCase.php';
require_once __DIR__.'/../library/PHPBench/Runner.php';

/**
 * PHP quotes bench
 */
class QuotesBench extends \PHPBench\BenchCase
{

    public function benchSingleQuotes1()
    {
        $foo = 'test';
    }
    public function benchSingleQuotes2()
    {
        $foo = 'test'.'test';
    }
    public function benchSingleQuotes3()
    {
        $bar = 'blah';
        $foo = 'test '.$bar.' test';
    }

    public function benchDoubleQuotes1()
    {
        $foo = "test";
    }
    public function benchDoubleQuotes2()
    {
        $foo = "test"."test";
    }
    public function benchDoubleQuotes3()
    {
        $bar = "blah";
        $foo = "test ".$bar." test";
    }
    public function benchDoubleQuotes4()
    {
        $bar = "blah";
        $foo = "test $bar test";
    }

}

$benchCase = new QuotesBench();
// Run each bench 100 000 times
$benchCase->setIterationNumber(100000);

$benchRunner = new \PHPBench\Runner();
$benchRunner->run($benchCase);
