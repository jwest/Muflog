<?php

namespace Muflog\Module;

use Muflog\Repository;

class ListingByDate extends \Muflog\Module {

    protected $route = '/(:year)(/:mounth)';
    protected $routeScheme = '/%s';
    
    public function get($year = null, $mounth = null) {
        $pagination = null;
        if ($year !== null && $mounth === null)
            $this->app->notFound();
        
        if ($year === null && $mounth === null)
    	   $pagination = $this->repository->page(null, 'ByDate');
        else
           $pagination = $this->repository->page($year.'/'.$mounth, 'ByDate');

    	$posts = $pagination->posts();
		if (empty($posts))
            $this->app->notFound();
		$this->app->render('listing.php', array('app' => $this->app, 'posts' => $posts, 'pagination' => $pagination));
    }

}