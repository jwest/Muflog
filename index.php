<?php
require 'vendor/autoload.php';

use Muflog\Repository;
use Gaufrette\Adapter\Local as LocalAdapter;

$posts = Repository::factory('post', new LocalAdapter('tests/fixtures/repository/posts'));
$pages = Repository::factory('page', new LocalAdapter('tests/fixtures/repository/pages'));

$app = new \Slim\Slim();
$app->add(new \Muflog\Module\Listing($posts));
$app->add(new \Muflog\Module\ListingByTag($posts));
$app->add(new \Muflog\Module\Post($posts));
$app->add(new \Muflog\Module\Page($pages));

$app->run();