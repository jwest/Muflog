<?php

use Muflog\Pagination;
use Muflog\Repository;
use Gaufrette\Adapter\Local as LocalAdapter;

class Muflog_Pagination_Test extends PHPUnit_Framework_TestCase {

	public function setUp() {
		$adapter = new LocalAdapter('tests/fixtures/repository');
		$this->repo = new Repository($adapter);
		$this->repo->itemsOnPage(2);
	}

	public function testCreateInstance() {
		$this->assertInstanceOf('\Muflog\Pagination', new Pagination($this->repo, 1));
	}

	public function testGetPosts() {
		$obj = new Pagination($this->repo, 1);
		$this->assertCount(2, $obj->posts());
	}

	public function testGetPage() {
		$obj = new Pagination($this->repo, 1);
		$this->assertEquals(1, $obj->page());
	}

	public function testGetMaxPage() {
		$obj = new Pagination($this->repo, 1);
		$this->assertEquals(2, $obj->max());
	}

	public function testGetNextPage() {
		$obj = new Pagination($this->repo, 2);
		$this->assertEquals(1, $obj->next());
	}

	public function testGetNextPageNonExists() {
		$obj = new Pagination($this->repo, 1);
		$this->assertEquals(false, $obj->next());
	}

	public function testGetPrevPage() {
		$obj = new Pagination($this->repo, 1);
		$this->assertEquals(2, $obj->prev());
	}

	public function testGetPrevPageNonExists() {
		$obj = new Pagination($this->repo, 2);
		$this->assertEquals(false, $obj->prev());
	}

	public function testGetPostsByPageFirstPage() {	
		$this->repo->itemsOnPage(3);	
		$obj = new Pagination($this->repo, 1);
		$this->assertCount(3, $obj->posts());
	}

	public function testGetPostsByPageOtherPage() {
		$this->repo->itemsOnPage(3);	
		$obj = new Pagination($this->repo, 2);
		$this->assertCount(1, $obj->posts());
	}

	public function testGetPostsByPageNonExistsPage() {
		$this->repo->itemsOnPage(3);	
		$obj = new Pagination($this->repo, 42);
		$this->assertEmpty($obj->posts());
	}

	public function testGetPostsByPageNonExistsPageLessThanOne() {
		$this->repo->itemsOnPage(3);	
		$obj = new Pagination($this->repo, 0);
		$this->assertEmpty($obj->posts());
	}
}