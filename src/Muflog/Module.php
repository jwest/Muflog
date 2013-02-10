<?php

namespace Muflog;

use Muflog\Repository;

abstract class Module extends \Slim\Middleware {

	protected $repository;
	protected $route;
	protected $routeScheme = null;
	protected $hasPagination = false;

	public function __construct(Repository $repository) {
		$this->repository = $repository;
	}

    public function call() {    	
    	$this->getModuleName();
        $this->app->get($this->route, array($this, 'get'))->name('post');
        $this->next->call();
    }

    public function getModuleName() {
    	$className = get_class($this);
    	$classNameParts = explode('\\', $className);
    	return $classNameParts[count($classNameParts)-1];
    }

    public function getRouteScheme() {
        if ($this->routeScheme !== null)
            return $this->routeScheme;
    	return preg_replace('/\(?\/\(?:([a-z0-9])+\)?/i', '/%s', $this->route);
    }

    public function hasPagination() {
    	return $this->hasPagination;
    }

}