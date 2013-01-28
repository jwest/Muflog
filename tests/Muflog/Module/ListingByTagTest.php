<?php

use Muflog\Module\ListingByTag;
use Muflog\Repository;
use Gaufrette\Adapter\Local as LocalAdapter;

class Muflog_Module_ListingByTagTest extends Muflog_Module_ModuleTesting {

    public function testGetRouteStatus() {
        $this->checkStatusCode('GET', '/tag/testTag', 200);
    }

    public function testGetRouteStatusOtherPage() {
        $this->checkStatusCode('GET', '/tag/testTag/1', 200);
    }

    public function testGetRouteStatusNonExistsPage() {
        $this->checkStatusCode('GET', '/tag/testTag/91', 404);
    }

    public function testGetRouteStatusNonExistsPageOther() {
        $this->checkStatusCode('GET', '/tag/testTag/0', 404);
    }

    public function getObj() {
        return new ListingByTag(Repository::factory(new LocalAdapter('tests/fixtures/repository'))->post());
    }

}