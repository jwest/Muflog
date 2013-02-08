<?php

namespace Muflog\Module;

use Muflog\Repository;

class Page extends \Muflog\Module {

	protected $route = '/page/:name';

    public function get($name) {
    	try {
			$page = $this->repository->page($name);
		} catch (\InvalidArgumentException $e) {
			$this->app->notFound();
		}
		$this->app->render('page.php', array('app' => $this->app, 'page' => $page));
    }

}