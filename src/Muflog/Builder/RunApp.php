<?php

namespace Muflog\Builder;

use Muflog\Repository;

class RunApp extends \Slim\Slim {

	private $content;
	private $repository;
	private $middlewares = array();

	public function __construct(Repository $repository) {
		$this->repository = $repository;		
	}

	public function add(\Slim\Middleware $newMiddleware) {
    	$this->middlewares[] = $newMiddleware;
    }

	private function init($route) {	
		\Slim\Environment::mock(array('PATH_INFO' => $route));
		parent::__construct();
		foreach ($this->middlewares as $middleware)
			parent::add($middleware);
	}

	public function run($route) {
		$this->init($route);
		ob_start();
		parent::run();
		$this->content = ob_get_clean();
		return $this->response()->status();
	}

	public function content() {
		return $this->content;
	}
}