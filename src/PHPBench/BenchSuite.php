<?php
/**
 * @author  Matthieu Napoli
 * @license LGPL v3 (See LICENSE file)
 */

namespace PHPBench;

require_once 'BenchCase.php';
use PHPBench\BenchCase;

/**
 * Bench suite
 */
abstract class BenchSuite
{

    /**
     * Path to look for bench cases
     * @var string
     */
	protected $_path;

    /**
     * Pattern to find bench case files
     * @var string
     */
    private $_filePattern = '/^([a-zA-Z0-9]+)Bench\.php$/';

    /**
     * Constructor
     *
     * Check that $this->_path is defined in subclasses
     */
    public function __construct()
    {
        if ($this->_path === null) {
            throw new \Exception('The protected property '.get_class($this).'::_path must be'
                .' defined to the directory to look for bench classes. Check the documentation.');
        }
        if (! is_dir($this->_path)) {
            throw new \Exception('The path defined by '.get_class($this).'::_path'
                .' is not an existing directory');
        }
    }

    /**
     * Method executed before the bench cases
     *
     * @return void
     */
    public function setUp()
    {
    }

    /**
     * Method executed after the bench cases
     *
     * @return void
     */
    public function tearDown()
    {
    }

    /**
     * Returns all the bench case of a directory
     *
     * The files where bench cases are looked for are named "XxxBench.php"
     *
     * @return array(BenchCase) Array of bench cases classes
     */
    public function getBenchCases()
    {
        $benchCases = array();
        $files = scandir($this->_path);
        foreach ($files as $filename) {
            $fullpath = realpath($this->_path.'/'.$filename);
            if (is_file($fullpath)
                && preg_match($this->_filePattern, basename($filename))) {
                $classname = basename($filename, '.php');
                require_once $fullpath;
                $benchCase = new $classname();
                if (! $benchCase instanceof BenchCase) {
                    throw new \Exception($benchCase.' class must extend PHPBench\BenchCase');
                }
                $benchCases[] = new $classname();
            }
        }
        return $benchCases;
    }

	public function getPath()
	{
		return $this->_path;
	}

}
