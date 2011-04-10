<?php
/**
 * @author Matthieu Napoli
 */

namespace PHPBench;

/**
 * Bench case
 */
class BenchCase
{

    /**
     * Number of iteration for the bench
     * @var int
     */
    private $_iterationNumber = 1;

    /**
     * Run the bench
     *
     * @return array((string) benchStep => (float) time)
     */
    public function run()
    {
        $benchSteps = $this->getBenchSteps();
        $time = array();
        // Set up
        $this->setUp();
        foreach ($benchSteps as $benchStep) {
            $timeStart = microtime(true);
            for ($i = 0; $i < $this->_iterationNumber; $i++) {
                $this->$benchStep();
            }
            $timeEnd = microtime(true);
            $time[$benchStep] = $timeEnd - $timeStart;
        }
        // Tear down
        $this->tearDown();
        return $time;
    }

    /**
     * Method executed before the bench
     *
     * @return void
     */
    public function setUp()
    {
    }

    /**
     * Method executed after the bench
     *
     * @return void
     */
    public function tearDown()
    {
    }

    /**
     * Get the iteration number
     *
     * @return int
     */
    public function getIterationNumber()
    {
        return $this->_iterationNumber;
    }

    /**
     * Set the iteration number
     *
     * @param int $iterationNumber Number of iteration for the bench
     *
     * @return void
     */
    public function setIterationNumber($iterationNumber)
    {
        $this->_iterationNumber = $iterationNumber;
    }

    /**
     * Returns all the bench steps of this bench case
     *
     * @return array(string) Array of the method names of the bench case class
     */
    protected function getBenchSteps()
    {
        $benchSteps = array();
        foreach (get_class_methods($this) as $method) {
            if (strpos($method, "bench") === 0) {
                $benchSteps[] = $method;
            }
        }
        return $benchSteps;
    }

}
