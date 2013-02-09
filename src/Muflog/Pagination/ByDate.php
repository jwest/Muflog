<?php

namespace Muflog\Pagination;

use Muflog\Pagination;

class ByDate extends Pagination {

	public function __construct(array $posts = array(), $page) {		
		parent::__construct($posts, $page);
		$this->page = $this->preparePage($this->page);
	}

	private function preparePage($page) {
		if ($page == null)
			return $this->pageForFirstPage();
		return explode('/', $page);		
	}

	public function posts() {
		return $this->postsForPage($this->page);
	}

	public function page() {
		return $this->page[0].'/'.$this->page[1];
	}

	public function max() {
		return -1;
	}

	public function prev() {
		return $this->searchNextDateElem($this->posts, $this->page);
	}

	public function next() {
		$posts = array_reverse($this->posts);
		return $this->searchNextDateElem($posts, $this->page);		
	}

	private function searchNextDateElem($posts, $page) {
		$searchIndex = false;
		foreach ($posts as $i => $post) {
			if ($this->compareDate($post, $page))
				$searchIndex = $i;
			else if ($searchIndex !== false)
				return $post->date()->format('Y/m');			
		}
		return false;
	}

	private function compareDate($post, $page) {
		return $post->date()->format('Y/m') === $page[0].'/'.$page[1];
	}

	private function postsForPage($page) {
		$obj = $this;
		return array_filter($this->posts, function($post) use ($obj, $page) {
			return $obj->compareDate($post, $page);
		});
	}

	private function pageForFirstPage() {
		if (isset($this->posts[0]))
			return array(
				$this->posts[0]->date()->format('Y'),
				$this->posts[0]->date()->format('m'),
			);
		return array(0, 0);
	}
}