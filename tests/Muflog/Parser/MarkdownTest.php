<?php

use Muflog\Parser\Markdown;
use Gaufrette\Filesystem;
use Gaufrette\Adapter\Local as LocalAdapter;

class Muflog_Parser_Markdown_Test extends PHPUnit_Framework_TestCase {

	public function setUp() {
		$this->obj = new Markdown(file_get_contents('tests/fixtures/repository/2012/12/test_post.md'));
	}

	public function testInstanceOf() {
		$this->assertInstanceOf('\Muflog\IParser', $this->obj);
	}

	public function testGetContent() {
		$this->assertContains('<h1>Test post', $this->obj->content());
	}

}