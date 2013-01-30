<?php

namespace Muflog;

use Gaufrette\File;
use Gaufrette\Filesystem;
use Muflog\Parser\Markdown;

class Page {

	private $fileName;
	private $title;
	private $content;

	public function __construct(File $file) {
		$this->fileName = $file->getKey();
		$this->parse($file->getContent());
	}

	public function fileName() {
		return $this->fileName;
	}

	public function name() {
		$part = explode('.', $this->fileName);
		unset($part[count($part)-1]);
		return implode('.', $part);
	}

	public function title() {
		return $this->title;
	}

	public function content() {
		return $this->content;
	}

	private function parse($content) {
		$md = new Markdown($content);
		$this->parseMeta($md->meta());
		$this->content = $md->content();
	}

	private function parseMeta(array $meta) {
		if (isset($meta['title']))
			$this->title = $meta['title'];		
	}

}