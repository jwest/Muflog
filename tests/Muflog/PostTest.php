<?php

use Muflog\Post;
use Gaufrette\Filesystem;
use Gaufrette\Adapter\Local as LocalAdapter;

class Muflog_Post_Test extends PHPUnit_Framework_TestCase {

	public function setUp() {
		$adapter = new LocalAdapter('tests/fixtures/repository');
		Post::driver(new Filesystem($adapter));
		$this->obj = new Post('2012/12/test_post.md');
	}

	public function testCreateInstance() {
		$this->assertInstanceOf('\Muflog\Post', $this->obj);
	}

	public function testCreateInstanceInvalidFile() {
		$this->setExpectedException('\InvalidArgumentException', 'file \'2012/12/testInvalidFile.md\' loaded error');
		$obj = new Post('2012/12/testInvalidFile.md');
	}

	public function testGetFileName() {
		$this->assertEquals('2012/12/test_post.md', $this->obj->fileName());
	}

	public function testGetTitle() {
		$this->assertEquals('test post', $this->obj->title());
	}

	public function testGetDate() {
		$this->assertEquals(new DateTime('2013-01-18'), $this->obj->date());
	}

	public function testGetTags() {
		$this->assertCount(5, $this->obj->tags());
	}

	public function testGetContent() {
		$this->assertContains('<h1>Test post', $this->obj->content());
	}

}