<?php

namespace Muflog\Parser;

use Muflog\IParser;
use dflydev\markdown\MarkdownExtraParser;

class Markdown implements IParser {

	private $meta;
	private $content;

	public function __construct($content) {
		$this->parse($content);
	}

	protected function parse($content) {
		$contentsPart = preg_split('/(\n){2,}/i', $content);
		$this->meta = $this->parseMeta($contentsPart[0]);
		unset($contentsPart[0]);
		$this->content = $this->parseMarkdown(implode("\n\n", $contentsPart));
	}
	
	private function parseMeta($content) {
		return parse_ini_string($content);
	}

	private function parseMarkdown($content) {
		$md = new MarkdownExtraParser();
		return $md->transformMarkdown($content);
	}

	public function meta() {
		return $this->meta;
	}

	public function content() {
		return $this->content;
	}


}