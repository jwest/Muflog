<?php

use Muflog\Repository;
use Muflog\Builder\RunApp;
use Gaufrette\Filesystem;
use Gaufrette\Adapter\Local as LocalAdapter;

class Muflog_Builder_RunApp_Test extends PHPUnit_Framework_TestCase {

	public function setUp() {
		$adapter = new LocalAdapter('tests/fixtures/repository');
		$this->repo = new Repository($adapter);
	}

	public function testInstanceOf() {
		$this->assertInstanceOf('\Muflog\Builder\RunApp', new RunApp($this->repo));
	}

	public function testNotExistsPage() {
		$obj = new RunApp($this->repo);
		$obj->add(new \Muflog\Module\Listing($this->repo));
		$this->assertEquals(404, $obj->run('/0'));	
	}

	public function testExistsPage() {
		$obj = new RunApp($this->repo);
		$obj->add(new \Muflog\Module\Listing($this->repo));
		$this->assertEquals(200, $obj->run('/1'));	
	}

	public function testGetContent() {
		$obj = new RunApp($this->repo);
		$obj->add(new \Muflog\Module\Listing($this->repo));
		$obj->run('/1');
		$this->assertNotEmpty($obj->content());
	}
}