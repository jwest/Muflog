<?php

namespace Muflog\Pagination;

use Muflog\Pagination;

class Simple extends Pagination {

	public function posts() {
		return $this->postsForPage($this->page);
	}

	public function max() {
		return floor(count($this->posts) / self::itemsOnPage());
	}

	public function next() {
		if ($this->checkPosts($this->page - 1))
			return $this->page - 1;
		return false;
	}

	public function prev() {		
		if ($this->checkPosts($this->page + 1))
			return $this->page + 1;
		return false;	
	}

	private function offset($page) {
		return ($page - 1) * self::itemsOnPage();
	}

	private function checkPosts($page) {
		return count($this->postsForPage($page)) > 0;
	}

	private function postsForPage($page) {
		if ($page < 1) 
			return array();
		$offset = $this->offset($page);
		return array_slice($this->posts, $offset, self::itemsOnPage());
	}

}