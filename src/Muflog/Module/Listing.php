<?php

namespace Muflog\Module;

use Muflog\Repository;

class Listing extends \Slim\Middleware {

	private $repository;

	public function __construct(Repository $repository) {
		$this->repository = $repository;
	}

    public function call() {
        $this->app->get('/(:page)', array($this, 'get'))->name('post');
        $this->next->call();
    }

    public function get($page = 1) {
    	$posts = $this->repository->page($page);
		if (empty($posts))
			$this->app->notFound();
		var_dump($posts);
    }

}