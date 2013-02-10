<?php

namespace Muflog\Builder;

use Slim\Middleware;
use Gaufrette\Filesystem;
use Muflog\Repository;

class App extends \Slim\Slim {

	private $output;
	private $repository;
	private $middlewares = array();

	private $callbackStart;
	private $callbackEnd;

	public function __construct(Repository $repository, Filesystem $output) {
		$this->output = $output;
		$this->repository = $repository;
	}

	public function addModule(Middleware $middleware, array $dataForRoute = array()) {
		$this->middlewares[] = array(			
			$middleware, $middleware->getRouteScheme(), $dataForRoute, $middleware->pagination()
		);
	}

	public function build($callbackStart = null, $callbackEnd = null) {
		$this->callbackStart = $callbackStart;
		$this->callbackEnd = $callbackEnd;

		foreach ($this->middlewares as $middleware) {
			list($middleware, $routeRaw, $dataForRoute, $pageIterator) = $middleware;			
			$this->iterateByItems($middleware, $routeRaw, $dataForRoute, $pageIterator);
		}

		$this->generateIndex();
	}

	private function iterateByItems(Middleware $middleware, $routeRaw, $dataForRoute, $pageIterator) {
		if (empty($dataForRoute)) {
			$this->prepareRun($middleware, $routeRaw, null, $pageIterator);
			return;
		}
		foreach ($dataForRoute as $data)
			$this->prepareRun($middleware, $routeRaw, $data, $pageIterator);
	}

	private function buildIndexPage($middleware) {
		$this->prepareEnv($middleware, $middleware->getRouteIndex());
		$this->runRoute($middleware->getRouteIndex().'index.html');
	}

	private function prepareRun(Middleware $middleware, $routeRaw, $data, $pageIterator) {
		$paginationObj = ($pageIterator !== null)
			? $this->repository->page(null, $pageIterator)
			: null;

		$this->buildIndexPage($middleware);

		while (true) {
			$this->callbackStart();
			
			$route = $this->prepareRoute($routeRaw, $data, $paginationObj);
			$this->prepareEnv($middleware, $route);

			$this->callbackEnd($route);
			if (!$this->runRoute($route) || $paginationObj == null || !$paginationObj->page())
				return;
			$paginationObj = $paginationObj->prevObj();

			if ($paginationObj === null)
				return;
		}
	}

	private function prepareRoute($route, $data, $page) {
		if ($page !== null)
			$page = $page->page();
		if ($data === null)
			return sprintf($route, $page);
		return sprintf($route, $data, $page);
	}

	private function prepareEnv(Middleware $middleware, $route) {		
		\Slim\Environment::mock(array('PATH_INFO' => $route));
		parent::__construct();
		parent::add($middleware);
	}

	private function runRoute($route) {
		ob_start();
		parent::run();
		$content = ob_get_clean();		
		if ($this->response()->status() !== 200)
			return false;
		$this->output->write(trim($route, '/'), $content, true);
		return true;
	}

	private function generateIndex() {
		foreach ($this->output->keys() as $key) {
			if (substr($key, -strlen('/1')) == '/1')
				$this->output->write(dirname($key).'/index.html', $this->output->read($key), true);
		}
		try {
			$this->output->write('index.html', $this->output->read(1), true);
		} catch (\Gaufrette\Exception\FileNotFound $e) {}
	}	

	public function middlewares() {
		return $this->middlewares;
	}

	private function callbackStart() {
		if ($this->callbackStart !== null)
			call_user_func($this->callbackStart);
	}

	private function callbackEnd($route) {
		if ($this->callbackEnd !== null)
			call_user_func($this->callbackEnd, $route);
	}

}
