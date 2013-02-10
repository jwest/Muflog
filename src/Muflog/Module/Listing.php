<?php

namespace Muflog\Module;

use Muflog\Repository;

class Listing extends \Muflog\Module {

    protected $route = '/(:page)';
    protected $pagination = 'Simple';
    
    public function get($page = 1) {
    	$pagination = $this->repository->page($page);
    	$posts = $pagination->posts();
		if (empty($posts))
			$this->app->notFound();
		$this->app->render('listing.php', array('app' => $this->app, 'posts' => $posts, 'pagination' => $pagination));
    }

}