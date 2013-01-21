<?php

namespace Muflog;

use Muflog\Post;
use Gaufrette\Filesystem;
use Gaufrette\Adapter\Local as LocalAdapter;

class Repository {

	private $fileSystem;
	private $posts = array();

	public function __construct(LocalAdapter $adapter = null) {
		$this->fileSystem = new Filesystem($adapter);
		$posts = $this->loadPosts();
		$this->posts = $this->sortPosts($posts);
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

	public function posts() {
		return $this->posts;		
	}

	protected function postFile($name) {
		if (!$this->fileSystem->has($name))
			throw new \InvalidArgumentException('file \''.$name.'\' loaded error');
		return $this->fileSystem->get($name);
	}

	public function post($name) {
		return new Post($this->postFile($name));
	}

}