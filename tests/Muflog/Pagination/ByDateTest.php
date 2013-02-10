<?php

use Muflog\Pagination;
use Muflog\Pagination\ByDate;
use Muflog\Repository;
use Gaufrette\Adapter\Local as LocalAdapter;

class Muflog_Pagination_ByDate_Test extends PHPUnit_Framework_TestCase {

	public function setUp() {
		$this->repo = Repository::factory('post', new LocalAdapter('tests/fixtures/repository/posts'));
		Pagination::itemsOnPage(2);
	}

	public function testCreateInstance() {
		$this->assertInstanceOf('\Muflog\Pagination', new ByDate($this->repo->posts(), '2013/03'));
	}

	public function testGetPosts() {
		$obj = new ByDate($this->repo->posts(), '2013/01');
		$this->assertCount(2, $obj->posts());
	}

	public function testGetPage() {
		$obj = new ByDate($this->repo->posts(), '2013/01');
		$this->assertEquals('2013/01', $obj->page());
	}

	public function testGetMaxPage() {
		$obj = new ByDate($this->repo->posts(), '2013/01');
		$this->assertEquals(-1, $obj->max());
	}

	public function testGetPrevEmptyPage() {
		$obj = new ByDate($this->repo->posts(), null);
		$this->assertEquals('2013/02', $obj->prev());
	}

	public function testGetPrevPage2() {
		$obj = new ByDate($this->repo->posts(), '2013/02');
		$this->assertEquals('2013/01', $obj->prev());
	}

	public function testGetPrevPage3() {
		$obj = new ByDate($this->repo->posts(), '2013/01');
		$this->assertEquals(false, $obj->prev());
	}

	public function testGetNextPage2() {
		$obj = new ByDate($this->repo->posts(), '2013/01');
		$this->assertEquals('2013/02', $obj->next());
	}

	public function testGetNextPage3() {
		$obj = new ByDate($this->repo->posts(), '2013/02');
		$this->assertEquals('2013/03', $obj->next());
	}

	public function testGetNextEmptyPage() {
		$obj = new ByDate($this->repo->posts(), null);
		$this->assertEquals(false, $obj->next());
	}

	public function testGetNextPaginationObj() {
		$obj = new ByDate($this->repo->posts(), '2013/02');
		$obj = $obj->nextObj();
		$this->assertInstanceOf('\\Muflog\\Pagination\\ByDate', $obj);
		$this->assertEquals('2013/03', $obj->page());
	}

	public function testGetPrevPaginationObj() {
		$obj = new ByDate($this->repo->posts(), '2013/03');
		$obj = $obj->prevObj();
		$this->assertInstanceOf('\\Muflog\\Pagination\\ByDate', $obj);
		$this->assertEquals('2013/02', $obj->page());
	}

	public function testGetNextPaginationObjNull() {
		$obj = new ByDate($this->repo->posts(), '2013/03');
		$obj = $obj->nextObj();
		$this->assertEquals(null, $obj);
	}

	public function testGetPrevPaginationObjNull() {
		$obj = new ByDate($this->repo->posts(), '2013/01');
		$obj = $obj->prevObj();
		$this->assertEquals(null, $obj);
	}

	public function testGetPostsByPageFirstPage() {	
		Pagination::itemsOnPage(3);	
		$obj = new ByDate($this->repo->posts(), null);
		$this->assertCount(1, $obj->posts());
	}

	public function testGetPostsByPageNonExistsPage() {
		Pagination::itemsOnPage(3);	
		$obj = new ByDate($this->repo->posts(), '2007/12');
		$this->assertEmpty($obj->posts());
	}

}