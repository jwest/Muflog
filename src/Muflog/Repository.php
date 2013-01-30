<?php

namespace Muflog;

use Gaufrette\Filesystem;
use Muflog\Repository\Post;
use Muflog\Repository\Page;
use Gaufrette\Adapter\Local as LocalAdapter;

abstract class Repository {

	const FILE_TYPE = '.md';

	protected $adapter;
	protected $fileSystem;

	public static function factory($name, LocalAdapter $adapter) {
		$className = 'Muflog\\Repository\\'.ucfirst($name);
		return new $className($adapter);
	} 

	protected function loadFile($name) {		
		if (!$this->fileSystem->has($name))
			throw new \InvalidArgumentException('file \''.$name.'\' loaded error');
		return $this->fileSystem->get($name);
	}

}
