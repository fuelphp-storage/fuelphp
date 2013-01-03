<?php
/**
 * Include the Composer autoloader.
 */
require '../vendor/autoload.php';

/**
 * Initialize the environment and start the application!
 */
\FuelPHP\Foundation\Environment::singleton()
	->init(
		array(
			'path' => '../packages',
			'application' => 'demo-package'
		)
	)
	->start();
