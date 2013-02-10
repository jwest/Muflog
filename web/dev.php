<?php
// use only in develop
// better way is rebuild blog after change posts

require '../vendor/autoload.php';

$config = new \Muflog\Config('../config.ini');

$app = new \Slim\Slim();
$app->config('absoluteUrl', $config->main('absoluteUrl'));
$app->config('templates.path', $config->main('templates'));

foreach ($config->modules() as $module)
	$app->add($module);

$app->run();