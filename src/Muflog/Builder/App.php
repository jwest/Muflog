<?php

namespace Muflog\Builder;

use Slim\Middleware;
use Gaufrette\Filesystem;

class App extends \Slim\Slim {

	private $output;
	private $middlewares = array();

	private $callbackStart;
	private $callbackEnd;

	public function __construct(Filesystem $output) {
		$this->output = $output;
	}

	public function addModule(Middleware $middleware) {
		$this->middlewares[] = $middleware;
	}

	public function build($callbackStart = null, $callbackEnd = null) {
		$this->callbackStart = $callbackStart;
		$this->callbackEnd = $callbackEnd;

		foreach ($this->middlewares as $middleware) {
			$this->iterateByItems($middleware);
		}

		$this->generateIndex();
	}

	private function iterateByItems(Middleware $middleware) {
		$dataForRoute = $middleware->data();
		if (empty($dataForRoute))
			return $this->prepareRun($middleware, null);
		foreach ($dataForRoute as $data)
			$this->prepareRun($middleware, $data);
	}

	private function buildMainPage($middleware) {
		$this->callbackStart();
		$this->prepareEnv($middleware, $middleware->routeIndex());
		$this->runRoute($middleware->routeIndex().'index.html');
		$this->callbackEnd($middleware->routeIndex().'index.html');
	}

	private function prepareRun(Middleware $middleware, $data) {
		$paginationObj = $middleware->pagination();

		if ($middleware->routeIndex() === '/')
			$this->buildMainPage($middleware);

		while (true) {
			$this->callbackStart();
			
			$route = $this->prepareRoute($middleware->routeScheme(), $data, $paginationObj);
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
		$config = $this->settings;
		parent::__construct();
		$this->settings = $config;
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
			if (substr($key, -strlen('/1')) == '/1') {
				$this->callbackStart();
				$this->output->write(dirname($key).'/index.html', $this->output->read($key), true);
				$this->callbackEnd(dirname($key).'/index.html');
			}
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
