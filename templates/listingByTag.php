<html>
<head>
	<title>MufLog</title>
	<style type="text/css">
		body {
		    width: 800px; margin: auto;
		    background-color: #eee;
		    font-family: sans-serif;
		}
		header {
		    display: block; margin-top: 20px;
		}
		header h1 {
		    padding: 0;
		    margin: 0;
		    font-family: serif;
		    font-size: 40pt;
		}
		header h1 a {
			color: 000;
			text-decoration: none;
		}
		header h3 {
		    margin: 0;
		    padding: 0;
		    color: #aaa;
		    margin-top: -16px;
		    text-shadow: 1px 1px #444;
		}
		article h2 a {
		    color: #555;
			font-weight: normal;
			font-family: serif;
			text-decoration: none;
			font-size: 25pt;
		}
		article h2 a:hover {
		    color: #66a;
		}
		article {
		    
		}
		.meta .datetime {
		    font-size: 10pt;
		    font-style: italic;
		    color: #888;
		}
		article > h2 {
		    margin-bottom: 0px;
		    text-align: right;
		}
		.meta .tags {
		    font-size: 10pt;
		    margin-left: 11px;
		    color: #888;
		}
		.meta {
		    background-color: #ddd;
		    padding: 3px 10px;
		    text-align: right;
		}
	</style>
</head>
<body>

	<header>
		<h1><a href="/muflog/web">Muflog</a></h1>
		<h3>Your markup files blog, Tag: `<?php echo $tag?>`</h3>
	</header>

	<section>
		<?php foreach ($posts as $post): ?>
			<article>
				<h2><a href="/muflog/web/post/<?php echo $post->name(); ?>"><?php echo $post->title(); ?></a></h2>
				<div class="meta">						
					<span class="tags">
						<?php foreach ($post->tags() as $postTag): ?>
							<a href="/muflog/web/tag/<?php echo $postTag?>"><?php echo $postTag; ?></a>		
						<?php endforeach ?>
					</span>
					<span class="datetime"><?php echo $post->date()->format('Y-m-d H:m'); ?></span>
				</div>
				<div>
					<?php echo $post->content(); ?>
				</div>
			</article>
		<?php endforeach ?>		
	</section>

	<div>
		<?php if ($pagination->next()): ?>
			<a href="/muflog/web/tag/<?php echo $tag ?>/<?php echo $pagination->next(); ?>">Next</a>
		<?php endif ?>

		<?php if ($pagination->prev()): ?>
			<a href="/muflog/web/tag/<?php echo $tag ?>/<?php echo $pagination->prev(); ?>">Prev</a>
		<?php endif ?>			
	</div>

</body>
</html>