<?php

use Muflog\Repository;
use Muflog\Repository\Page;
use Gaufrette\Adapter\Local as LocalAdapter;

class Muflog_Repository_Page_Test extends PHPUnit_Framework_TestCase {

	public function setUp() {
		$this->repo = Repository::factory('page', new LocalAdapter('tests/fixtures/repository'));
	}

	public function testCreateInstance() {
		$this->assertInstanceOf('\Muflog\Repository', $this->repo);
	}

	public function testGetPages() {
		$this->assertCount(4, $this->repo->pages());
	}

	public function testGetPage() {
		//$this->assertInstanceOf('\Muflog\Page', $this->repo->post('test_post_2'));
	}

}
