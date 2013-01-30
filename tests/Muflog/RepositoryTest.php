<?php

use Muflog\Repository;
use Muflog\Repository\Post;
use Gaufrette\Adapter\Local as LocalAdapter;

class Muflog_Repository_Test extends PHPUnit_Framework_TestCase {

	public function testCreateByFactory() {
		$adapter = new LocalAdapter('tests/fixtures/repository/posts');	
		$this->assertInstanceOf('\Muflog\Repository\Post', Repository::factory('post', $adapter));
	}

	public function testGetPostRepository() {
		$repo = Repository::factory('post', new LocalAdapter('tests/fixtures/repository/posts'));	
		$this->assertInstanceOf('\Muflog\Repository\Post', $repo);
	}
}
