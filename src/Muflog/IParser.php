<?php

namespace Muflog;

interface IParser {

	public function __construct($content);
	
	public function meta();

	public function content();

}