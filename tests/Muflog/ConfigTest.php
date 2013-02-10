<?php

use Muflog\Config;
use Gaufrette\Filesystem;
use Gaufrette\Adapter\Local as LocalAdapter;

class Muflog_Config_Test extends PHPUnit_Framework_TestCase {

	public function setUp() {
		$this->fs = 'tests/fixtures/main/config.ini';
	}

	public function testCreateInstance() {
		$this->assertInstanceOf('\Muflog\Config', new Config($this->fs));
	}

	public function testCreateInvalidInstance() {
		$this->setExpectedException('\InvalidArgumentException', 'Config file notExists not exists');
		new Config('notExists');
	}

	public function testGetRepositoryInstance() {
		$config = new Config($this->fs);
		$this->assertInstanceOf('\Muflog\Repository\Post', $config->repository('post'));
	}

	public function testGetInvalidRepositoryInstance() {
		$this->setExpectedException('\InvalidArgumentException', 'Repository testNotExists not exists');
		$config = new Config($this->fs);
		$config->repository('testNotExists');
	}

	public function testGetModuleInstance() {
		$config = new Config($this->fs);
		$this->assertInstanceOf('\Muflog\Module\Post', $config->module('post'));
	}

	public function testGetInvalidModuleInstance() {
		$this->setExpectedException('\InvalidArgumentException', 'Module testNotExists not exists');
		$config = new Config($this->fs);
		$config->module('testNotExists');
	}

	public function testGetModulesInstanceOf() {
		$config = new Config($this->fs);
		$modules = $config->modules();
		$this->assertInstanceOf('\Muflog\Module', $modules[0]);
	}

	public function testGetModulesCount() {
		$config = new Config($this->fs);
		$modules = $config->modules();
		$this->assertCount(4, $modules);
	}

	public function testGetMainConfigAbsoluteUrl() {
		$config = new Config($this->fs);
		$this->assertEquals('http://localhost/muflog/web', $config->main('absoluteUrl'));
	}

	public function testGetMainConfigTemplates() {
		$config = new Config($this->fs);
		$this->assertEquals('templates', $config->main('templates'));
	}

	public function testGetMainConfigNotExists() {
		$this->setExpectedException('\InvalidArgumentException', 'Config testNotExists not exists');
		$config = new Config($this->fs);
		$config->main('testNotExists');
	}

}