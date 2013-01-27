<?php

use Muflog\Module\Listing;
use Muflog\Repository;
use Gaufrette\Adapter\Local as LocalAdapter;

class Muflog_Module_ListingTest extends Muflog_Module_ModuleTesting {

    public function testGetRouteStatus() {
        $this->checkStatusCode('GET', '/', 200);
    }

    public function testGetRouteStatusOtherPage() {
        $this->checkStatusCode('GET', '/1', 200);
    }

    public function testGetRouteStatusNonExistsPage() {
        $this->checkStatusCode('GET', '/91', 404);
    }

    public function testGetRouteStatusNonExistsPageOther() {
        $this->checkStatusCode('GET', '/0', 404);
    }

    public function testGetSchema() {
        $obj = $this->getObj();
        $obj::ROUTE_SCHEMA;
    }

    public function getObj() {
        return new Listing(new Repository(new LocalAdapter('tests/fixtures/repository')));
    }

}