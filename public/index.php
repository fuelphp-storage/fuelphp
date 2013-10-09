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
 * Application document root
 */
define('DOCROOT', __DIR__.DIRECTORY_SEPARATOR);

/**
 * Path to the applications directory.
 */
define('APPSPATH', realpath(__DIR__.'/../apps/').DIRECTORY_SEPARATOR);

/**
 * Path to the vendor directory.
 */
define('VENDORPATH', realpath(__DIR__.'/../vendor/').DIRECTORY_SEPARATOR);

/**
 * Start the framework
 */
require VENDORPATH.'autoload.php';

/**
 * Forge the demo application environment...
 */
$app = Application::forge('demo', array(
	'namespace' => null,
	'environment' => isset($_SERVER['FUEL_ENV']) ? $_SERVER['FUEL_ENV'] : 'development'
));

/**
 * Define some test modules
 */

// add all modules at once. This makes them all routable!
$app->addModulePath(Application::get('demo')->getPath().'modules');

/*
// or add modules individually, which gives you more control over their definition
$app->addModule('moda', 'Moda', Application::get('demo')->getPath().'modules'.DS.'moda', true)
    ->addModule('modb', 'Modb', Application::get('demo')->getPath().'modules'.DS.'modb', false);
*/

/**
 * Get the demo application, fire the main request on it, and get the response
 */
try
{
	$response = $app->getRequest()->execute()->getResponse();
}
catch (\Fuel\Foundation\Exception\BadRequest $e)
{
	// check if a 400 route is defined
	if ( ! $route = $app->getRouter()->getRoute('400'))
	{
		// rethrow the BadRequest exception
		throw $e;
	}
}
catch (\Fuel\Foundation\Exception\NotAuthorized $e)
{
	// check if a 401 route is defined
	if ( ! $route = $app->getRouter()->getRoute('401'))
	{
		// rethrow the NotAuthorized exception
		throw $e;
	}
}
catch (\Fuel\Foundation\Exception\Forbidden $e)
{
	// check if a 403 route is defined
	if ( ! $route = $app->getRouter()->getRoute('403'))
	{
		// rethrow the Forbidden exception
		throw $e;
	}
}
catch (\Fuel\Foundation\Exception\NotFound $e)
{
	// check if a 404 route is defined
	if ( ! $route = $app->getRouter()->getRoute('404'))
	{
		// rethrow the NotFound exception
		throw $e;
	}
}
catch (\Fuel\Foundation\Exception\ServerError $e)
{
	// check if a 500 route is defined
	if ( ! $route = $app->getRouter()->getRoute('500'))
	{
		// rethrow the ServerError exception
		throw $e;
	}
}

// check if a new route is defined
if (isset($route))
{
	// call it
	$response = $app->getRequest($route->translation)->execute()->getResponse();
}

/**
 * send the response headers out
 */
$response->sendHeaders();

/**
 * Output the response body and replace the profiling values. You can remove this
 * if you don't use it, to speed up the output
 */
if (strpos($response, '{exec_time}') !== false or strpos($response, '{mem_usage}') !== false or strpos($response, '{mem_peak_usage}') !== false)
{
	/**
	 * Compile profiling data, add it to the response, and send it on it's way
	 */
	echo str_replace(
		array(
			'{exec_time}',
			'{mem_usage}',
			'{mem_peak_usage}'
		),
		array(
			round(microtime(true)-FUEL_START_TIME, 4),
			round((memory_get_usage()-FUEL_START_MEM)/1024/1024, 4),
			round((memory_get_peak_usage()-FUEL_START_MEM)/1024/1024, 4)
		),
		$response
	);
}
else
{
	/**
	 * Just send out the response
	 */
	echo $response;
}
