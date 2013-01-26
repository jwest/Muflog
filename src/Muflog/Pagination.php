<?php

namespace Muflog;

use Muflog\Repository;

class Pagination {

	private $repository;
	private $page;

	public function __construct(Repository $repository, $page) {
		$this->repository = $repository;
		$this->page = $page;
	}

	public function posts() {
		return $this->postsForPage($this->page);
	}

	public function page() {
		return $this->page;
	}

	public function max() {
		return floor(count($this->repository->posts()) / $this->repository->itemsOnPage());
	}

	public function next() {
		if ($this->checkPosts($this->page + 1))
			return $this->page+1;
		return false;
	}

	public function prev() {		
		if ($this->checkPosts($this->page - 1))
			return $this->page-1;
		return false;	
	}

	private function offset($page) {
		return ($page - 1) * $this->repository->itemsOnPage();
	}

	private function checkPosts($page) {
		return count($this->postsForPage($page)) > 0;
	}

	private function postsForPage($page) {
		if ($page < 1) 
			return array();
		$offset = $this->offset($page);
		return array_slice($this->repository->posts(), $offset, $this->repository->itemsOnPage());
	}
}