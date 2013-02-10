<?php

namespace Muflog\Repository;

use Muflog\Post as PostEntity;
use Muflog\Repository;
use Gaufrette\Filesystem;
use Gaufrette\Adapter\Local as LocalAdapter;

class Post extends Repository {

	private $posts = array();

	public function __construct(LocalAdapter $adapter) {
		$this->fileSystem = new Filesystem($adapter);
		$posts = $this->loadPosts();
		$this->posts = $this->sortPosts($posts);
	}

	public function posts() {
		return $this->posts;
	}

	public function page($page, $paginationClass = 'Simple') {
		$paginationClass = '\\Muflog\\Pagination\\'.ucfirst($paginationClass);
		return new $paginationClass($this->posts(), $page);
	}

	public function post($name, $withoutType = false) {
		if (!$withoutType)
			$name = $name . self::FILE_TYPE;
		return new PostEntity($this->loadFile($name));
	}

	public function pageByTag($page, $tag, $paginationClass = 'Simple') {
		$paginationClass = '\\Muflog\\Pagination\\'.ucfirst($paginationClass);
		return new $paginationClass($this->postsByTag($tag), $page);
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
		$repository = $this;
		return array_map(function($post) use ($repository) {
			return substr($post, 0, strlen($repository::FILE_TYPE) * -1);
		}, $posts);
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
