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
    	$posts = $this->repository->page($page)->posts();
		if (empty($posts))
			$this->app->notFound();
		$this->app->render('layout.php', array('posts' => $posts));
    }

}