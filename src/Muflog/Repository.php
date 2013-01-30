<?php

namespace Muflog;

use Gaufrette\Filesystem;
use Muflog\Repository\Post;
use Muflog\Repository\Page;
use Gaufrette\Adapter\Local as LocalAdapter;

abstract class Repository {

	const FILE_TYPE = '.md';

	private $adapter;

	public static function factory($name, LocalAdapter $adapter) {
		$className = 'Muflog\\Repository\\'.ucfirst($name);
		return new $className($adapter);
	} 
}
