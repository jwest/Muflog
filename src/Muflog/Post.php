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

	public function __construct(File $file) {
		$this->fileName = $file->getKey();
		$this->date = new \DateTime('@'.$file->getMtime());
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

	public function date() {
		return $this->date;
	}

	public function tags() {
		return $this->tags;
	}

	public function hasTag($tag) {
		return in_array($tag, $this->tags);
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
		if (isset($meta['date']))
			$this->date = new \DateTime($meta['date']);
		$this->tags = explode(',', $meta['tags']);		
	}

}