<?php

namespace Muflog;

use Gaufrette\Filesystem;
use Muflog\Repository\Post;
use Gaufrette\Adapter\Local as LocalAdapter;

class Repository {

	const FILE_TYPE = '.md';

	private $adapter;

	public static function factory(LocalAdapter $adapter) {
		return new self($adapter);
	} 

	protected function __construct(LocalAdapter $adapter) {
		$this->adapter = $adapter;
	}

	public function post() {
		return new Post($this->adapter);
	}

}
