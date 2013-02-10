<?php

use Muflog\Module\ListingByDate;
use Muflog\Repository;
use Gaufrette\Adapter\Local as LocalAdapter;

class Muflog_Module_ListingByDateTest extends Muflog_Module_ModuleTesting {

    public function testGetRouteStatus() {
        $this->checkStatusCode('GET', '/', 200);
    }

    public function testGetRouteStatusOtherPage() {
        $this->checkStatusCode('GET', '/2013/01', 200);
    }

    public function testGetRouteStatusInvalidRoute() {
        $this->checkStatusCode('GET', '/2013', 404);
    }

    public function testGetRouteStatusNonExistsPage() {
        $this->checkStatusCode('GET', '/2007/10', 404);
    }

    public function testGetRouteStatusNonExistsPageOther() {
        $this->checkStatusCode('GET', '/0', 404);
    }

    public function getObj() {
        return new ListingByDate(Repository::factory('post', new LocalAdapter('tests/fixtures/repository/posts')));
    }

    public function renderTemplateName() {
        return 'listing.php';
    }
}