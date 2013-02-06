<?php

namespace Muflog\Module;

use Muflog\Repository;

class Post extends \Slim\Middleware {

	const ROUTE_SCHEMA = '/post/%s';
    const PAGE_ITERATE = false;

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
		$this->app->render('post.php', array('app' => $this->app, 'post' => $post));
    }

}