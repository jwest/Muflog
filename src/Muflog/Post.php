<?php

namespace Muflog;

use Gaufrette\File;
use Gaufrette\Filesystem;
use Muflog\Parser\Markdown;

class Post {

	private $fileName;
	private $title;
	private $date;
	private $tags;
	private $content;

	public function __construct(File $file, Filesystem $fileSystem) {
		$this->fileName = $file->getKey();
		$this->date = new \DateTime('@'.$fileSystem->mtime($this->fileName));		
		$this->parse($file->getContent());
	}

	public function fileName() {
		return $this->fileName;
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

	private function parse($content) {
		$md = new Markdown($content);
		$meta = $md->meta();
		if (isset($meta['title']))
			$this->title = $meta['title'];
		if (isset($meta['date']))
			$this->date = new \DateTime($meta['date']);
		$this->tags = explode(',', $meta['tags']);
		$this->content = $md->content();
	}

}