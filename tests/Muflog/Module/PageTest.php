<?php

use Muflog\Module\Page;
use Muflog\Repository;
use Gaufrette\Adapter\Local as LocalAdapter;

class Muflog_Module_PageTest extends Muflog_Module_ModuleTesting {

    public function testGetRouteStatus() {
        $this->checkStatusCode('GET', '/page/test_page', 200);
    }

    public function testGetRouteStatusOtherPage() {
        $this->checkStatusCode('GET', '/page/test_page_2', 200);
    }

    public function testGetRouteStatusNonExistsPage() {
        $this->checkStatusCode('GET', '/page/test_post_non_exist', 404);
    }

    public function getObj() {
        return new Page(Repository::factory('page', new LocalAdapter('tests/fixtures/repository/pages')));
    }

}