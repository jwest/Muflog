<?php

use Muflog\Parser\Markdown;
use Gaufrette\Filesystem;
use Gaufrette\Adapter\Local as LocalAdapter;

class Muflog_Parser_Markdown_Test extends PHPUnit_Framework_TestCase {

	public function setUp() {
		$this->obj = new Markdown(file_get_contents('tests/fixtures/repository/test_post.md'));
	}

	public function testInstanceOf() {
		$this->assertInstanceOf('\Muflog\IParser', $this->obj);
	}

	public function testGetContent() {
		$this->assertContains('<h1>Test post', $this->obj->content());
	}

	public function testGetMetaTitle() {
		$meta = $this->obj->meta();
		$this->assertEquals('test post', $meta['title']);
	}

	public function testGetMetaDate() {
		$meta = $this->obj->meta();
		$this->assertEquals('2013-01-18', $meta['date']);
	}

	public function testGetMetaTags() {
		$meta = $this->obj->meta();
		$this->assertEquals('test,post,testTag,php,unit,phpunit', $meta['tags']);
	}

}
