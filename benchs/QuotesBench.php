<?php
/**
 * @author Matthieu Napoli
 */

require_once __DIR__.'/../library/PHPBench/BenchCase.php';

/**
 * PHP quotes bench
 */
class QuotesBench extends \PHPBench\BenchCase
{

    /**
     * Run each bench 500000 times
     */
    protected $_iterationNumber = 500000;

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
