<?php

namespace Muflog\Repository;

use Muflog\Page as PageEntity;
use Muflog\Repository;
use Gaufrette\Filesystem;
use Gaufrette\Adapter\Local as LocalAdapter;

class Page extends Repository {

	private $pages = array();

	public function __construct(LocalAdapter $adapter) {
		$this->fileSystem = new Filesystem($adapter);
		$this->pages = $this->loadPages();
		$this->adapter = $adapter;
	}

	public function pages() {
		return $this->pages;
	}

	private function loadPages() {
		$pages = $this->fileSystem->keys();
		$repository = $this;
		return array_map(function($page) use ($repository) {
			return $repository->page($page, true);
		}, $pages);
	}

	public function page($name, $withoutType = false) {
		if (!$withoutType)
			$name = $name . self::FILE_TYPE;
		return new PageEntity($this->loadFile($name));
	}

	public function keys() {
		$pages = $this->fileSystem->keys();
		$repository = $this;
		return array_map(function($page) use ($repository) {
			return substr($page, 0, strlen($repository::FILE_TYPE) * -1);
		}, $pages);
	}

}