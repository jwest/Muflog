<?php

namespace Muflog\Module;

use Muflog\Repository;

class ListingByTag extends \Muflog\Module {

    protected $route = '/tag/:tag(/:page)';
    protected $pagination = 'Simple';
    
    public function get($tag, $page = 1) {
    	$pagination = $this->repository->pageByTag($page, $tag);
    	$posts = $pagination->posts();
		if (empty($posts))
			$this->app->notFound();
		$this->app->render('listingByTag.php', array('app' => $this->app, 'tag' => $tag, 'posts' => $posts, 'pagination' => $pagination));
    }

    public function data() {
    	return array_keys($this->repository->tags());
    }

}