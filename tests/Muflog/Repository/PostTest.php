<?php

use Muflog\Repository;
use Muflog\Repository\Post;
use Gaufrette\Adapter\Local as LocalAdapter;

class Muflog_Repository_Post_Test extends PHPUnit_Framework_TestCase {

	public function setUp() {
		$this->repo = Repository::factory('post', new LocalAdapter('tests/fixtures/repository/posts'));
	}

	public function testCreateInstance() {
		$this->assertInstanceOf('\Muflog\Repository', $this->repo);
	}

	public function testGetPosts() {
		$this->assertCount(4, $this->repo->posts());
	}

	public function testGetPostsCheckInstanceOf() {		
		$posts = $this->repo->posts();
		$this->assertInstanceOf('\Muflog\Post', $posts[0]);
	}

	public function testGetKeys() {
		$this->assertCount(4, $this->repo->keys());
	}

	public function testGetKeysCheckIsString() {
		$posts = $this->repo->keys();
		$this->assertContains('test_post', $posts[0]);
	}

	public function testGetPostsByTags() {
		$this->assertCount(2, $this->repo->postsByTag('testTag'));
	}

	public function testGetPostsByTagsCheckInstanceOf() {
		$posts = $this->repo->postsByTag('testTag');
		$this->assertInstanceOf('\Muflog\Post', $posts[0]);
	}

	public function testGetPost() {
		$this->assertInstanceOf('\Muflog\Post', $this->repo->post('test_post_2'));
	}

	public function testGetPostsOrderCheck() {
		$posts = $this->repo->posts();
		$this->assertEquals('test_post_3.md', $posts[0]->fileName());	
	}

	public function testGetPaginationInstance() {
		\Muflog\Pagination::itemsOnPage(2);
		$this->assertInstanceOf('\Muflog\Pagination', $this->repo->page(1));
	}

	public function testGetByTagPaginationInstance() {
		\Muflog\Pagination::itemsOnPage(2);
		$posts = $this->repo->pageByTag(1, 'testTag')->posts();
		$this->assertCount(2, $posts);
	}

	public function testGetAllTags() {
		$this->assertCount(8, $this->repo->tags());
	}

	public function testDateNotExistsInPostFile() {
		$repo = Repository::factory('post', new LocalAdapter('tests/fixtures/repository/posts'));
		$post = $repo->post('test_post_4_without_date');
		$this->assertEquals(filemtime('tests/fixtures/repository/posts/test_post_4_without_date.md'), $post->date()->getTimestamp());
	}
}
