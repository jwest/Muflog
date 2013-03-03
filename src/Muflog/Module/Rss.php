<?php

namespace Muflog\Module;

use Suin\RSSWriter\Feed;
use Suin\RSSWriter\Channel;
use Suin\RSSWriter\Item;
use Muflog\Repository;

class Rss extends \Muflog\Module {

    protected $route = '/rss';

    public function get($tag = null) {
    	$posts = $this->loadPosts($tag);
		if (empty($posts))
			$this->app->notFound();

		$feed = new Feed();
		$channel = $this->prepareChannel($feed);

		foreach ($posts as $post)
			$this->preparePost($channel, $post);

		$this->app->response()->body($feed);
    }
    
    private function loadPosts() {
    	$posts = $this->repository->posts();		
    	return array_slice($posts, 0, 3);
    }

    private function prepareChannel(Feed $feed) {
		$channel = new Channel();
		$channel
		    ->title($this->app->config('blog.title'))
		    ->description($this->app->config('blog.description'))
		    ->url($this->app->config('absoluteUrl'))
		    ->appendTo($feed);
		return $channel;
    }

    private function preparePost(Channel $channel, $post) {
    	$item = new Item();
		$item->title($post->title())
		    ->description($post->content())
		    ->url($this->app->config('absoluteUrl').'/post/'.$post->name())
		    ->appendTo($channel);
    }

    public function data() {
    	return array('index');
    }

}