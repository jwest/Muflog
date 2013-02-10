<?php

namespace Muflog;

abstract class Pagination {

	protected $posts;
	protected $page;
	protected $className;

	public function __construct(array $posts = array(), $page) {
		$this->posts = $posts;
		$this->page = $page;
		$this->className = get_called_class();
	}

	public function page() {
		return $this->page === null ? 1 : $this->page;
	}

	abstract public function next();
	
	abstract public function prev();

	abstract public function max();

	abstract public function posts();

	public function nextObj() {
		$next = $this->next();
		if ($next !== false)
			return new $this->className($this->posts, $this->next());
		return null;
	}

	public function prevObj() {
		$prev = $this->prev();
		if ($prev !== false)
			return new $this->className($this->posts, $this->prev());
		return null;
	}

	protected static $itemsOnPage = 3;

	public static function itemsOnPage($itemsCount = null) {
		if ($itemsCount !== null)
			self::$itemsOnPage = $itemsCount;
		return self::$itemsOnPage;
	}
}