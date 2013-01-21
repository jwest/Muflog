<?php

use Muflog\Repository;
use Gaufrette\Adapter\Local as LocalAdapter;

class Muflog_Repository_Test extends PHPUnit_Framework_TestCase {

	public function testCreateInstance() {
		$adapter = new LocalAdapter('tests/fixtures/repository');
		$this->assertInstanceOf('\Muflog\Repository', new Repository($adapter));
	}

	public function testGetPosts() {
		$repo = new Repository(new LocalAdapter('tests/fixtures/repository'));	
		$this->assertCount(3, $repo->posts());
	}

	public function testGetPostsOrderCheck() {
		$repo = new Repository(new LocalAdapter('tests/fixtures/repository'));	
		$this->assertEquals('test_post_2.md', $repo->posts()[0]->fileName());	
	}

	public function testGetPostsByPageFirstPage() {
		$repo = new Repository(new LocalAdapter('tests/fixtures/repository'));
		$repo->itemsOnPage(2);
		$this->assertCount(2, $repo->page(1));
	}

	public function testGetPostsByPageSecoundPage() {
		$repo = new Repository(new LocalAdapter('tests/fixtures/repository'));
		$repo->itemsOnPage(2);
		$this->assertCount(1, $repo->page(2));
	}
}