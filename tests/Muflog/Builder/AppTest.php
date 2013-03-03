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
		$this->assertInstanceOf('\Muflog\Builder\App', new App($this->out));
	}

	protected function getObj() {
		$obj = new App($this->out);
		$obj->config('absoluteUrl', 'http://localhost');
		$obj->config('templates.path', 'templates');
		return $obj;
	}

	public function testAddMiddlewareForGenerate() {
		$obj = $this->getObj();
		$obj->addModule(new \Muflog\Module\Post($this->repo), $this->in->keys());
		$middlewares = $obj->middlewares();
		$this->assertInstanceOf('\Slim\Middleware', $middlewares[0]);
	}

	public function testBuildPostModule() {
		$obj = $this->getObj();
		$obj->addModule(new \Muflog\Module\Post($this->repo));
		$obj->build();		
		$this->assertTrue($this->out->has('post/test_post/index.html'));
		$this->assertTrue($this->out->has('post/test_post_2/index.html'));
	}

	public function testBuildListingModule() {
		$obj = $this->getObj();
		$obj->addModule(new \Muflog\Module\Listing($this->repo));
		$obj->build();
		$this->assertTrue($this->out->has('1/index.html'));
		$this->assertTrue($this->out->has('2/index.html'));
	}

	public function testBuildListingByTagModule() {
		\Muflog\Pagination::itemsOnPage(1);
		$obj = $this->getObj();
		$obj->addModule(new \Muflog\Module\ListingByTag($this->repo));
		$obj->build();
		$this->assertTrue($this->out->has('tag/testTag/1/index.html'));
		$this->assertTrue($this->out->has('tag/testTag/2/index.html'));
	}

	public function testBuildListingByDateModule() {
		\Muflog\Pagination::itemsOnPage(1);
		$obj = $this->getObj();
		$obj->addModule(new \Muflog\Module\ListingByDate($this->repo));
		$obj->build();
		$this->assertTrue($this->out->has('2013/01/index.html'));
		$this->assertTrue($this->out->has('2013/03/index.html'));
	}

	public function testBuildListingByDateModuleIndexCheck() {
		\Muflog\Pagination::itemsOnPage(1);
		$obj = $this->getObj();
		$obj->addModule(new \Muflog\Module\ListingByDate($this->repo));
		$obj->build();
		$this->assertTrue($this->out->has('index.html'));
	}

	public function testCallbackStartRunOnBuildRoute() {
		$obj = $this->getObj();
		$obj->addModule(new \Muflog\Module\Post($this->repo));
		try {
			$obj->build(function(){
				throw new CallbackException('test');		
			});
			$this->fail();
		} catch (CallbackException $e) {}
	}

	public function testCallbackEndRunOnBuildRoute() {
		$obj = $this->getObj();
		$obj->addModule(new \Muflog\Module\Post($this->repo));
		try {
			$obj->build(null, function($route){
				throw new CallbackException('test');
			});
			$this->fail();
		} catch (CallbackException $e) {}
	}

	public function testCallbackEndRunOnBuildWithArgRoute() {
		$obj = $this->getObj();
		$obj->addModule(new \Muflog\Module\Post($this->repo));
		$test = $this;
		$obj->build(null, function($route) use ($test) {
			$test->assertContains('/post/test_post', $route);
			$test->assertContains('index.html', $route);
		});		
	}

	public function testCheckIndexExists() {
		$obj = $this->getObj();
		$obj->addModule(new \Muflog\Module\Listing($this->repo));
		$obj->build();
		$this->assertTrue($this->out->has('index.html'));
	}

	public function testSetConfig() {
		$obj = $this->getObj();
		$obj->config('cookies.lifetime', 'time');
		$obj->addModule(new \Muflog\Module\Listing($this->repo));		
		$obj->build();
		$this->assertEquals('time', $obj->config('cookies.lifetime'));
	}
}

class CallbackException extends Exception {}