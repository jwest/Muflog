<?php

namespace Muflog;

abstract class Pagination {

	protected $posts;
	protected $page;

	public function __construct(array $posts = array(), $page) {
		$this->posts = $posts;
		$this->page = $page;
	}

	public function page() {
		return $this->page;
	}

	abstract public function next();
	abstract public function prev();
	abstract public function max();
	abstract public function posts();

	protected static $itemsOnPage = 3;

	public static function itemsOnPage($itemsCount = null) {
		if ($itemsCount !== null)
			self::$itemsOnPage = $itemsCount;
		return self::$itemsOnPage;
	}
}