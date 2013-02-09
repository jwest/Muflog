<?php

use Muflog\Repository;
use Muflog\Builder\App;
use Gaufrette\Filesystem;
use Gaufrette\Adapter\Local as LocalAdapter;
use Gaufrette\Adapter\InMemory as MemoryAdapter;

class Muflog_Builder_App_Test extends PHPUnit_Framework_TestCase {

	public function setUp() {
		$adapter = new LocalAdapter('tests/fixtures/repository/posts');
		$this->repo = Repository::factory('post', $adapter);
		$this->in = new Filesystem($adapter);
		$memory = new MemoryAdapter();
		$this->out = new Filesystem($memory);
	}

	public function testInstanceOf() {
		$this->assertInstanceOf('\Muflog\Builder\App', new App($this->repo, $this->out));
	}

	public function testAddMiddlewareForGenerate() {
		$obj = new App($this->repo, $this->out);
		$obj->addModule(new \Muflog\Module\Post($this->repo), $this->in->keys());
		$middlewares = $obj->middlewares();
		$this->assertCount(4, $middlewares[0]);
	}

	public function testBuildPostModule() {
		$obj = new App($this->repo, $this->out);
		$obj->addModule(new \Muflog\Module\Post($this->repo), array('test_post', 'test_post_2'));
		$obj->build();		
		$this->assertTrue($this->out->has('post/test_post'));
		$this->assertTrue($this->out->has('post/test_post_2'));
	}

	public function testBuildListingModule() {
		$obj = new App($this->repo, $this->out);
		$obj->addModule(new \Muflog\Module\Listing($this->repo));
		$obj->build();
		$this->assertTrue($this->out->has('1'));
		$this->assertTrue($this->out->has('2'));
	}

	public function testBuildListingByTagModule() {
		\Muflog\Pagination::itemsOnPage(1);
		$obj = new App($this->repo, $this->out);
		$obj->addModule(new \Muflog\Module\ListingByTag($this->repo), array_keys($this->repo->tags()));
		$obj->build();
		$this->assertTrue($this->out->has('tag/testTag/1'));
		$this->assertTrue($this->out->has('tag/testTag/2'));
	}

	public function testCallbackStartRunOnBuildRoute() {
		$obj = new App($this->repo, $this->out);
		$obj->addModule(new \Muflog\Module\Post($this->repo));
		try {
			$obj->build(function(){
				throw new CallbackException('test');		
			});
			$this->fail();
		} catch (CallbackException $e) {}
	}

	public function testCallbackEndRunOnBuildRoute() {
		$obj = new App($this->repo, $this->out);
		$obj->addModule(new \Muflog\Module\Post($this->repo));
		try {
			$obj->build(null, function($route){
				throw new CallbackException('test');
			});
			$this->fail();
		} catch (CallbackException $e) {}
	}

	public function testCallbackEndRunOnBuildWithArgRoute() {
		$obj = new App($this->repo, $this->out);
		$obj->addModule(new \Muflog\Module\Post($this->repo), array('test_post', 'test_post_2'));
		$test = $this;
		$obj->build(null, function($route) use ($test) {
			$test->assertContains('/post/test_post', $route);
		});		
	}

	public function testCheckIndexExists() {
		$obj = new App($this->repo, $this->out);
		$obj->addModule(new \Muflog\Module\Listing($this->repo));
		$obj->build();
		$this->assertTrue($this->out->has('index.html'));
	}
}

class CallbackException extends Exception {}