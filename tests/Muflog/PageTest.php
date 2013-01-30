<?php

use Muflog\Page;
use Muflog\Repository;
use Gaufrette\Filesystem;
use Gaufrette\Adapter\Local as LocalAdapter;

class Muflog_Page_Test extends PHPUnit_Framework_TestCase {

	public function setUp() {
		$this->repo = Repository::factory('page', new LocalAdapter('tests/fixtures/repository/pages'));
		$this->obj = $this->repo->page('test_page');
	}

	public function testCreateInstance() {
		$this->assertInstanceOf('\Muflog\Page', $this->obj);
	}

	public function testCreateInstanceInvalidFile() {
		$this->setExpectedException('\InvalidArgumentException', 'file \'testInvalidFile.md\' loaded error');
		$this->repo->page('testInvalidFile');
	}

	public function testGetFileName() {
		$this->assertEquals('test_page.md', $this->obj->fileName());
	}

	public function testGetNameWithoutType() {
		$this->assertEquals('test_page', $this->obj->name());
	}

	public function testGetTitle() {
		$this->assertEquals('test page', $this->obj->title());
	}

	public function testGetContent() {
		$this->assertContains('<h1>Test page', $this->obj->content());
	}

}