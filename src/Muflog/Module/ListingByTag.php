<?php

namespace Muflog\Module;

use Muflog\Repository;

class ListingByTag extends \Slim\Middleware {

    const ROUTE_SCHEMA = '/tag/%s/%d';
    const PAGE_ITERATE = true;

	private $repository;

	public function __construct(Repository $repository) {
		$this->repository = $repository;
	}

    public function call() {
        $this->app->get('/tag/:tag(/:page)', array($this, 'get'))->name('tag');
        $this->next->call();
    }

    public function get($tag, $page = 1) {
    	$pagination = $this->repository->pageByTag($page, $tag);
    	$posts = $pagination->posts();
		if (empty($posts))
			$this->app->notFound();
		$this->app->render('layout.php', array('posts' => $posts, 'pagination' => $pagination));
    }

}