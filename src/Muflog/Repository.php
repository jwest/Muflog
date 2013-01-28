<?php

namespace Muflog;

use Muflog\Post;
use Muflog\Pagination;
use Gaufrette\Filesystem;
use Gaufrette\Adapter\Local as LocalAdapter;

class Repository {

	const FILE_TYPE = '.md';

	private $fileSystem;
	private $posts = array();

	public function __construct(LocalAdapter $adapter = null) {
		$this->fileSystem = new Filesystem($adapter);
		$posts = $this->loadPosts();
		$this->posts = $this->sortPosts($posts);
	}

	public function posts() {
		return $this->posts;
	}

	public function page($page) {		
		return new Pagination($this->posts(), $page);
	}

	public function post($name, $withoutType = false) {
		if (!$withoutType)
			$name = $name . self::FILE_TYPE;
		return new Post($this->postFile($name));
	}

	public function pageByTag($page, $tag) {
		return new Pagination($this->postsByTag($tag), $page);
	}

	public function postsByTag($tag) {
		return array_filter($this->posts, function($post) use ($tag) {
			return $post->hasTag($tag);
		});
	}

	public function tags() {
		$tags = array();
		foreach ($this->posts() as $post)
			$tags = array_merge($tags, $post->tags());
		return array_count_values($tags);
	}

	public function keys() {
		$posts = $this->fileSystem->keys();
		return array_map(function($post) {
			return substr($post, 0, strlen(self::FILE_TYPE) * -1);
		}, $posts);
	}

	protected function postFile($name) {		
		if (!$this->fileSystem->has($name))
			throw new \InvalidArgumentException('file \''.$name.'\' loaded error');
		return $this->fileSystem->get($name);
	}

	private function loadPosts() {
		$posts = $this->fileSystem->keys();
		$repository = $this;
		return array_map(function($post) use ($repository) {
			return $repository->post($post, true);
		}, $posts);
	}

	private function sortPosts(array $posts) {
		usort($posts, function($a, $b) {
			if ($a->date()->getTimestamp() == $b->date()->getTimestamp()) {
		        return 0;
		    }
		    return ($a->date()->getTimestamp() > $b->date()->getTimestamp()) ? -1 : 1;			
		});
		return $posts;
	}

}
