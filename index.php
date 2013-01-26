<?php
require 'vendor/autoload.php';

use Muflog\Repository;
use Gaufrette\Adapter\Local as LocalAdapter;

$adapter = new LocalAdapter('tests/fixtures/repository');
$repository = new Repository($adapter);

$app = new \Slim\Slim();
$app->add(new \Muflog\Module\Listing($repository));
$app->add(new \Muflog\Module\Post($repository));

$app->run();