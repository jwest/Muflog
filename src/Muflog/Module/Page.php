<?php

namespace Muflog\Module;

use Muflog\Repository;

class Page extends \Slim\Middleware {

	const ROUTE_SCHEMA = '/page/%s';
    const PAGE_ITERATE = false;

	private $repository;

	public function __construct(Repository $repository) {
		$this->repository = $repository;
	}

    public function call() {
        $this->app->get('/page/:name', array($this, 'get'))->name('page');
        $this->next->call();
    }

    public function get($name) {
    	try {
			$page = $this->repository->page($name);
		} catch (\InvalidArgumentException $e) {
			$this->app->notFound();
		}
		$this->app->render('layout.php', array('app' => $this->app, 'page' => $page));
    }

}