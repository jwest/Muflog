<?php

use Muflog\Pagination;
use Muflog\Pagination\Simple;
use Muflog\Repository;
use Gaufrette\Adapter\Local as LocalAdapter;

class Muflog_Pagination_Simple_Test extends PHPUnit_Framework_TestCase {

	public function setUp() {
		$this->repo = Repository::factory('post', new LocalAdapter('tests/fixtures/repository/posts'));
		Pagination::itemsOnPage(2);
	}

	public function testItemsOnPage() {
		Pagination::itemsOnPage(5);
		$this->assertEquals(5, Pagination::itemsOnPage());
	}

	public function testCreateInstance() {
		$this->assertInstanceOf('\Muflog\Pagination', new Simple($this->repo->posts(), 1));
	}

	public function testGetPosts() {
		$obj = new Simple($this->repo->posts(), 1);
		$this->assertCount(2, $obj->posts());
	}

	public function testGetPage() {
		$obj = new Simple($this->repo->posts(), 1);
		$this->assertEquals(1, $obj->page());
	}

	public function testGetMaxPage() {
		$obj = new Simple($this->repo->posts(), 1);
		$this->assertEquals(2, $obj->max());
	}

	public function testGetNextPage() {
		$obj = new Simple($this->repo->posts(), 2);
		$this->assertEquals(1, $obj->next());
	}

	public function testGetNextPageNonExists() {
		$obj = new Simple($this->repo->posts(), 1);
		$this->assertEquals(false, $obj->next());
	}

	public function testGetPrevPage() {
		$obj = new Simple($this->repo->posts(), 1);
		$this->assertEquals(2, $obj->prev());
	}

	public function testGetPrevPageNonExists() {
		$obj = new Simple($this->repo->posts(), 2);
		$this->assertEquals(false, $obj->prev());
	}

	public function testGetPostsByPageFirstPage() {	
		Pagination::itemsOnPage(3);	
		$obj = new Simple($this->repo->posts(), 1);
		$this->assertCount(3, $obj->posts());
	}

	public function testGetPostsByPageOtherPage() {
		Pagination::itemsOnPage(3);	
		$obj = new Simple($this->repo->posts(), 2);
		$this->assertCount(1, $obj->posts());
	}

	public function testGetPostsByPageNonExistsPage() {
		Pagination::itemsOnPage(3);	
		$obj = new Simple($this->repo->posts(), 42);
		$this->assertEmpty($obj->posts());
	}

	public function testGetPostsByPageNonExistsPageLessThanOne() {
		Pagination::itemsOnPage(3);	
		$obj = new Simple($this->repo->posts(), 0);
		$this->assertEmpty($obj->posts());
	}
}