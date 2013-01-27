<?php

use Muflog\Post;
use Muflog\Repository;
use Gaufrette\Filesystem;
use Gaufrette\Adapter\Local as LocalAdapter;

class Muflog_Post_Test extends PHPUnit_Framework_TestCase {

	public function setUp() {
		$adapter = new LocalAdapter('tests/fixtures/repository');
		$this->repo = new Repository($adapter);
		$this->obj = $this->repo->post('test_post');
	}

	public function testCreateInstance() {
		$this->assertInstanceOf('\Muflog\Post', $this->obj);
	}

	public function testCreateInstanceInvalidFile() {
		$this->setExpectedException('\InvalidArgumentException', 'file \'testInvalidFile.md\' loaded error');
		$this->repo->post('testInvalidFile');
	}

	public function testGetFileName() {
		$this->assertEquals('test_post.md', $this->obj->fileName());
	}

	public function testGetNameWithoutType() {
		$this->assertEquals('test_post', $this->obj->name());
	}

	public function testGetTitle() {
		$this->assertEquals('test post', $this->obj->title());
	}

	public function testGetDate() {
		$this->assertEquals(new DateTime('2013-01-18'), $this->obj->date());
	}

	public function testGetDateFromFileModifyDate() {
		$this->obj = $this->repo->post('test_post_4_without_date');
		$this->assertEquals(new DateTime('@'.filemtime('tests/fixtures/repository/test_post_4_without_date.md')), $this->obj->date());
	}

	public function testGetTags() {
		$this->assertCount(6, $this->obj->tags());
	}

	public function testHasTag() {
		$this->assertTrue($this->obj->hasTag('testTag'));
	}

	public function testGetContent() {
		$this->assertContains('<h1>Test post', $this->obj->content());
	}

}