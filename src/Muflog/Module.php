<?php

namespace Muflog;

use Muflog\Repository;

abstract class Module extends \Slim\Middleware {

	protected $repository;
	protected $route;
	protected $routeScheme = null;
    protected $routeIndex = null;
	protected $pagination = null;

	public function __construct(Repository $repository) {
		$this->repository = $repository;
	}

    public function call() {    	
    	$this->moduleName();
        $this->app->get($this->route, array($this, 'get'))->name('post');
        $this->next->call();
    }

    public function moduleName() {
    	$className = get_class($this);
    	$classNameParts = explode('\\', $className);
    	return $classNameParts[count($classNameParts)-1];
    }

    public function routeIndex() {
        if ($this->routeIndex !== null)
            return $this->routeIndex;
        return preg_replace('/\((.)+\)/i', '', $this->route);
    }

    public function routeScheme() {
        if ($this->routeScheme !== null)
            return $this->routeScheme;
    	return preg_replace('/\(?\/\(?:([a-z0-9])+\)?/i', '/%s', $this->route);
    }

    public function pagination() {
    	return $this->pagination;
    }

    public function data() {
        return array();
    }

}