<?php

namespace Muflog\Module;

use Muflog\Post;

class Post extends \Slim\Middleware {

    public function call() {
        $this->app->get('/:year/:mounth/:title', array($this, 'get'))->name('post');
        $this->next->call();
    }

    public function get($year, $mounth, $title) {
		        
    }

}