<?php

namespace Muflog\Module;

use Muflog\Repository;

class Post extends \Slim\Middleware {

	private $repository;

	public function __construct(Repository $repository) {
		$this->repository = $repository;
	}

    public function call() {
        $this->app->get('/post/:name', array($this, 'get'))->name('post');
        $this->next->call();
    }

    public function get($name) {
    	try {
			$post = $this->repository->post($name);
		} catch (\InvalidArgumentException $e) {
			$this->app->notFound();
		}
		$this->app->render('layout.php', array('posts' => array($post)));
    }

}