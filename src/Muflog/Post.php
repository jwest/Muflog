<?php

namespace Muflog;

use Gaufrette\Filesystem;

class Post {

	private $name;

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

	protected function load($name) {
		if (!self::driver()->has($name))
			throw new \InvalidArgumentException('file \''.$name.'\' loaded error');
		
	}

	protected static $driver = null;

	public static function driver(Filesystem $driver = null) {
		if ($driver !== null)
			self::$driver = $driver;
		return self::$driver;
	}
	
}