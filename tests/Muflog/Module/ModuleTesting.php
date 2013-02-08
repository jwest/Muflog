<?php

abstract class Muflog_Module_ModuleTesting extends PHPUnit_Framework_TestCase {

    abstract public function getObj();

    public function checkStatusCode($method, $route, $status, $input = '', array $params = array()) {
        $app = $this->slimMock($method, $route, $input, $params);
        $app->add($this->getObj());
        $app->run();
        $this->assertEquals($status, $app->response()->status());
        return $app;
    }

    public function checkOutput($method, $route, $output, $input = '', array $params = array()) {
        $app = $this->slimMock($method, $route, $input, $params);
        $app->add($this->getObj());
        $app->run();
        $this->assertEquals($output, $app->response()->body());
        return $app;
    }

    public function setUp() {
        ob_start();
    }

    public function tearDown() {
        ob_clean();
    }

    public function prepareMock() {
        $app = $this->getMock('\Slim\Slim', array('render'), array(array(
            'log.writer' => new \Slim\LogWriter(fopen('php://stderr', 'w')),
        )));

        $app->expects($this->any())
            ->method('render')
            ->with($this->renderTemplateName(), $this->renderParams());

        return $app;
    }

    public function renderTemplateName() {
        return 'layout.php';
    }

    public function renderParams() {
        return $this->arrayHasKey('app');
    }

    private function slimMock($method, $route, $input = '', array $params = array()) {
        $params = array_merge(array('PATH_INFO' => $route), $params);
        \Slim\Environment::mock($params);

        $app = $this->prepareMock();

        $app->setName(md5($method.$route));
        return $app;
    }

}