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
$autoloader = require VENDORPATH.'autoload.php';

/**
 * Bootstrap the framework
 */
\Fuel::bootstrap($autoloader);

/**
 * Setup the demo application environment...
 */
$demoApp = \Fuel::setApp(array(
	'name' => 'demo',
	'namespace' => null,
	'environment' => isset($_SERVER['FUEL_ENV']) ? $_SERVER['FUEL_ENV'] : 'development'
));

/**
 * and a test one with a custom path and a namespace...
 */
$testApp = \Fuel::setApp(array(
	'name' => array('test' => APPSPATH.'demo'),
	'namespace' => 'Test\Namespace',
	'environment' => 'production'
));

/**
 * Load the demo application and fire the main request
 */
$response = $demoApp
	->request()
	->execute()
	->getResponse()
	->sendHeaders()
	->getContent();

/**
 * Compile profiling data
 */
$execTime = round(microtime(true)-FUEL_START_TIME, 5);
$memUsage = round((memory_get_usage()-FUEL_START_MEM)/1024/1024, 4);
$memPeakUsage = round((memory_get_peak_usage()-FUEL_START_MEM)/1024/1024, 4);

/**
 * Output the response body and replace the profiling values
 */
echo str_replace(
	array('{exec_time}', '{mem_usage}', '{mem_peak_usage}'),
	array($execTime,     $memUsage,     $memPeakUsage),
	$response
);
