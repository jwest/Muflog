<?php

namespace Muflog\Repository;

use Muflog\Page as PageEntity;
use Muflog\Repository;
use Gaufrette\Filesystem;
use Gaufrette\Adapter\Local as LocalAdapter;

class Page extends Repository {

	private $fileSystem;
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
		//return new PageEntity($this->pageFile($name));
	}

}