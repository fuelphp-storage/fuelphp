<?php
/**
 * @package    Fuel
 * @version    2.0
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2017 Fuel Development Team
 * @link       http://fuelphp.com
 */

require '../vendor/autoload.php';

use Fuel\Foundation\Application;

/**
 * Set error reporting and display errors settings.
 * You may want to change these when in production.
 */
error_reporting(-1);
ini_set('display_errors', 1);

/**
 * System root
 */
define('ROOTPATH', __DIR__ . DIRECTORY_SEPARATOR . '..');

/**
 * Application document root
 */
define('DOCROOT', __DIR__ . DIRECTORY_SEPARATOR);

/**
 * Path to the vendor directory
 */
define('VENDORPATH', realpath(__DIR__ . '/../vendor/') . DIRECTORY_SEPARATOR);

define('DS', DIRECTORY_SEPARATOR);

// Get the start time and memory for use later
$startTime = microtime(true);
$startMem = memory_get_usage();

$app = Application::init([
	'components' => [
		'Fuel\Demo',
	],
]);

$response = $app->run();

$responseBody = (string) $response->getBody();

if (strpos($responseBody, '{exec_time}') !== false or strpos($responseBody, '{mem_usage}') !== false)
{
	$time = microtime(true) - $startTime;
	$mem = memory_get_usage() - $startMem;

	$responseBody = str_replace(
		array('{exec_time}', '{mem_usage}'),
		array(round($time, 4), round($mem / pow(1024, 2), 3)),
		$responseBody
	);
}

http_response_code($response->getStatusCode());
echo $responseBody;
