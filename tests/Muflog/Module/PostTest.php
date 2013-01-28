<?php

use Muflog\Module\Post;
use Muflog\Repository;
use Gaufrette\Adapter\Local as LocalAdapter;

class Muflog_Module_PostTest extends Muflog_Module_ModuleTesting {

    public function testGetRouteStatus() {
        $this->checkStatusCode('GET', '/post/test_post', 200);
    }

    public function testGetRouteStatusOtherPage() {
        $this->checkStatusCode('GET', '/post/test_post_2', 200);
    }

    public function testGetRouteStatusNonExistsPage() {
        $this->checkStatusCode('GET', '/post/test_post_non_exist', 404);
    }

    public function getObj() {
        return new Post(Repository::factory(new LocalAdapter('tests/fixtures/repository'))->post());
    }

}