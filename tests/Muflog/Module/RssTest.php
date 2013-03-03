<?php

use Muflog\Module\Rss;
use Muflog\Repository;
use Gaufrette\Adapter\Local as LocalAdapter;

class Muflog_Module_RssTest extends Muflog_Module_ModuleTesting {

    public function testGetRouteStatus() {
        $this->checkStatusCode('GET', '/rss', 200);
    }

    public function getObj() {
        return new Rss(Repository::factory('post', new LocalAdapter('tests/fixtures/repository/posts')));
    }

    public function renderTemplateName() {
        return null;
    }

}