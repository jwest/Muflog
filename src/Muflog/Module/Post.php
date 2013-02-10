<?php

namespace Muflog\Module;

use Muflog\Repository;

class Post extends \Muflog\Module {

	protected $route = '/post/:name';

    public function get($name) {
    	try {
			$post = $this->repository->post($name);
		} catch (\InvalidArgumentException $e) {
			$this->app->notFound();
		}
		$this->app->render('post.php', array('app' => $this->app, 'post' => $post));
    }

    public function data() {
    	return $this->repository->keys();
    }

}