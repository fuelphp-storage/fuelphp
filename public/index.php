<?php
/**
 * @package    Fuel
 * @version    2.0
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2013 Fuel Development Team
 * @link       http://fuelphp.com
 */

/**
 * Set error reporting and display errors settings.
 * You will want to change these when in production.
 */
error_reporting(-1);
ini_set('display_errors', 1);

// Get the start time and memory for use later
defined('FUEL_START_TIME') or define('FUEL_START_TIME', microtime(true));
defined('FUEL_START_MEM') or define('FUEL_START_MEM', memory_get_usage());

/**
 * shortcut for directory separator
 */
define('DS', DIRECTORY_SEPARATOR);

/**
 * application document root
 */
define('DOCROOT', __DIR__.DS);

/**
 * Path to the applications directory.
 */
define('APPSPATH', realpath(__DIR__.'/../apps/').DS);

/**
 * Path to the vendor directory.
 */
define('VENDORPATH', realpath(__DIR__.'/../vendor/').DS);

/**
 * Include the Composer autoloader
 */
require VENDORPATH.'autoload.php';

/**
 * Setup the demo application environment...
 */
\Fuel::setApp(
	'demo',
	isset($_SERVER['FUEL_ENV']) ? $_SERVER['FUEL_ENV'] : 'development'
);

/**
 * and a test one...
 */
\Fuel::setApp(
	array('test' => APPSPATH.'demo'),
	'production'
);

/**
 * Load the demo application and fire the main request
 */
$response = \Fuel::getApp('demo');

var_dump($response);

die('stop');


/**
 * and get us some response
 */

$response = $env->loadApplication()
	->request($env->input->getPathInfo())
	->execute()
	->getResponse()
	->sendHeaders()
	->getContent();

/**
 * Compile profiling data
 */
$execTime = round($env->profiler->getTimeElapsed(), 5);
$memUsage = round($env->profiler->getMemUsage() / 1000000, 4);
$memPeakUsage = round($env->profiler->getMemUsage(true) / 1000000, 4);

/**
 * Output the response body and replace the profiling values
 */
echo str_replace(
	array('{exec_time}', '{mem_usage}', '{mem_peak_usage}'),
	array($execTime,     $memUsage,     $memPeakUsage),
	$response
);
