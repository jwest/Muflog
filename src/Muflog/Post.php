<?php

namespace Muflog;

use Gaufrette\Filesystem;
use Muflog\Parser\Markdown;

class Post {

	private $name;
	private $title;
	private $date;
	private $tags;
	private $content;

	public function __construct($name) {
		$fileContent = $this->load($name);
		$this->name = $name;
	}

	public function fileName() {
		return $this->name;
	}

	public function title() {
		return $this->title;
	}

	public function date() {
		return $this->date;
	}

	public function tags() {
		return $this->tags;
	}

	public function content() {
		return $this->content;
	}

	protected function load($name) {
		if (!self::driver()->has($name))
			throw new \InvalidArgumentException('file \''.$name.'\' loaded error');
		$content = self::driver()->read($name);
		$this->parse($content);
	}

	private function parse($content) {
		$md = new Markdown($content);
		$meta = $md->meta();
		$this->title = $meta['title'];
		$this->date = new \DateTime($meta['date']);
		$this->tags = explode(',', $meta['tags']);
		$this->content = $md->content();
	}

	protected static $driver = null;

	public static function driver(Filesystem $driver = null) {
		if ($driver !== null)
			self::$driver = $driver;
		return self::$driver;
	}
	
}