<?php

namespace Muflog;

use Muflog\Post;
use Gaufrette\Filesystem;
use Gaufrette\Adapter\Local as LocalAdapter;

class Repository {

	protected $itemsOnPage;

	private $fileSystem;
	private $posts = array();

	public function __construct(LocalAdapter $adapter = null) {
		$this->fileSystem = new Filesystem($adapter);
		$posts = $this->loadPosts();
		$this->posts = $this->sortPosts($posts);
	}

	public function itemsOnPage($items = null) {
		if ($items !== null)
			$this->itemsOnPage = $items;
		return $items;
	}

	public function posts() {
		return $this->posts;
	}

	public function page($page) {
		$offset = ($page-1) * $this->itemsOnPage;
		return array_slice($this->posts, $offset, $this->itemsOnPage);
	}

	public function post($name) {
		return new Post($this->postFile($name));
	}

	protected function postFile($name) {
		if (!$this->fileSystem->has($name))
			throw new \InvalidArgumentException('file \''.$name.'\' loaded error');
		return $this->fileSystem->get($name);
	}

	private function loadPosts() {
		$posts = $this->fileSystem->keys();
		return array_map(function($post) {
			return $this->post($post);
		}, $posts);
	}

	private function sortPosts(array $posts) {
		usort($posts, function($a, $b) {
			if ($a->date()->getTimestamp() == $b->date()->getTimestamp()) {
		        return 0;
		    }
		    return ($a->date()->getTimestamp() < $b->date()->getTimestamp()) ? -1 : 1;			
		});
		return $posts;
	}

}