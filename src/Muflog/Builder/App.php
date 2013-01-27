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

	public function addModule(Middleware $middleware, array $dataForUrl = null) {
		$this->middlewares[] = array(			
			$middleware, $middleware::ROUTE_SCHEMA, $dataForUrl
		);
	}

	public function build($indexFile, $callbackStart = null, $callbackEnd = null) {
		$this->callbackStart = $callbackStart;
		$this->callbackEnd = $callbackEnd;
		foreach ($this->middlewares as $middleware) {
			list($middleware, $routeRaw, $dataForUrl) = $middleware;
			if ($dataForUrl === null)
				$this->iterateByNumbers($middleware, $routeRaw);
			else
				$this->iterateByItems($middleware, $routeRaw, $dataForUrl);
		}
		$this->generateIndex($indexFile);
	}

	private function generateIndex($from) {
		$this->output->write('index.html', $this->output->read($from), true);
	}	

	private function iterateByItems(Middleware $middleware, $routeRaw, array $dataForUrl) {
		foreach ($dataForUrl as $data)
			$this->prepareRun($middleware, $routeRaw, $data);
	}

	private function iterateByNumbers(Middleware $middleware, $routeRaw) {
		for ($i=1; true; ++$i)
			if (!$this->prepareRun($middleware, $routeRaw, $i))
				break;
	}

	private function prepareRun(Middleware $middleware, $routeRaw, $data) {
		if ($this->callbackStart !== null)
			call_user_func($this->callbackStart);
		$route = $this->prepareRoute($routeRaw, $data);				
		$this->prepareEnv($middleware, $route);				
		$result = $this->runRoute($route);
		if ($this->callbackEnd !== null)
			call_user_func($this->callbackEnd, $route);
		return $result;
	}

	private function prepareRoute($route, $data) {
		return sprintf($route, $data);
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

	public function middlewares() {
		return $this->middlewares;
	}

}