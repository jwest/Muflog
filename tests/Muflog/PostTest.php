<?php

use Muflog\Post;

class Muflog_Post_Test extends PHPUnit_Framework_TestCase {

	public function setUp() {
		$this->obj = new Post('2012/12/test_post.md');
	}

	public function testCreateInstance() {
		$this->assertInstanceOf('\Muflog\Post', $this->obj);
	}

	public function testCreateInstanceInvalidFile() {
		$this->setExpectedException('\InvalidArgumentException', 'file \'2012/12/testInvalidFile.md\' not loaded');
		$obj = new Post('2012/12/testInvalidFile.md');
	}

	// public function testGetTitle() {
	// 	$this->
	// }

}