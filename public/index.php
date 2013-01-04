<?php
/**
 * Include the Composer autoloader
 */
require '../vendor/autoload.php';

/**
 * Load and initialize the application environment...
 */
$env = FuelPHP::resolve('Environment')->init(
	array(
		'name'        => isset($_SERVER['FUEL_ENV']) ? $_SERVER['FUEL_ENV'] : 'development',
		'application' => 'demo-package',
		'path'        => '../packages',
	)
);

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
