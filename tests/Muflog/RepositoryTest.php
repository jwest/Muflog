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
		$this->assertCount(4, $repo->posts());
	}

	public function testGetPost() {
		$repo = new Repository(new LocalAdapter('tests/fixtures/repository'));		
		$this->assertInstanceOf('\Muflog\Post', $repo->post('test_post_2'));
	}

	public function testGetPostsOrderCheck() {
		$repo = new Repository(new LocalAdapter('tests/fixtures/repository'));
		$this->assertEquals('test_post_3.md', $repo->posts()[0]->fileName());	
	}

	public function testGetPaginationInstance() {
		$repo = new Repository(new LocalAdapter('tests/fixtures/repository'));
		$repo->itemsOnPage(2);
		$this->assertInstanceOf('\Muflog\Pagination', $repo->page(1));
	}

	public function testDateNotExistsInPostFile() {
		$repo = new Repository(new LocalAdapter('tests/fixtures/repository'));
		$post = $repo->post('test_post_4_without_date');
		$this->assertEquals(filemtime('tests/fixtures/repository/test_post_4_without_date.md'), $post->date()->getTimestamp());
	}
}