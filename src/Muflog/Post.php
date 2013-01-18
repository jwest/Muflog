<?php

namespace Muflog;

class Post {

	private $name;

	public function __construct($name) {
		if (!file_exists($name))
			throw new \InvalidArgumentException('file \''.$name.'\' loaded error');			
		$this->name = $name;
	}
	
}