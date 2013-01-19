<?php

namespace Muflog\Parser;

use Muflog\IParser;

class Markdown implements IParser {

	private $meta;
	private $content;

	public function __construct($content) {
		$this->parse($content);
	}

	protected function parse($content) {

	}
	
	public function meta() {

	}

	public function content() {

	}


}