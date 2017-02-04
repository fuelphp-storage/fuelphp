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
define('ROOTPATH', __DIR__.DIRECTORY_SEPARATOR.'..');

/**
 * Application document root
 */
define('DOCROOT', __DIR__.DIRECTORY_SEPARATOR);

/**
 * Path to the vendor directory
 */
define('VENDORPATH', realpath(__DIR__.'/../vendor/').DIRECTORY_SEPARATOR);

define('DS', DIRECTORY_SEPARATOR);

$app = Application::init([
	'components' => [
		'Fuel\Demo',
	],
]);

$app->run();
