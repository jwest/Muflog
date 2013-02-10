<?php

namespace Muflog;

use Gaufrette\Filesystem;
use Muflog\Repository;
use Gaufrette\Adapter\Local as LocalAdapter;

class Config {

	protected $config = array();

	public function __construct($configFile) {
		$this->config = $this->loadConfigFile($configFile);
	}

	protected function loadConfigFile($configFile) {
		if (!file_exists($configFile))
			throw new \InvalidArgumentException('Config file '.$configFile.' not exists');
		return parse_ini_file($configFile, true);
	}

	public function main($name) {
		if (!isset($this->config['main'][$name]))
			throw new \InvalidArgumentException('Config '.$name.' not exists');
		return $this->config['main'][$name];
	}

	public function repository($name) {
		if (!isset($this->config['repositories'][$name]))
			throw new \InvalidArgumentException('Repository '.$name.' not exists');
		$path = $this->config['repositories'][$name];
		return Repository::factory($name, new LocalAdapter($path));
	}

	public function module($name) {
		if (!isset($this->config['modules'][$name]))
			throw new \InvalidArgumentException('Module '.$name.' not exists');
		$moduleName = '\\Muflog\\Module\\'.ucfirst($name);
		$repoName = $this->config['modules'][$name];
		return new $moduleName($this->repository($repoName));
	}

	public function modules() {
		$modules = array();
		foreach ($this->config['modules'] as $module => $repo)
			$modules[] = $this->module($module);
		return $modules;
	}

}