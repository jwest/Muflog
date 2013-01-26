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
		    color: #66f;
		    text-transform: uppercase;
		    font-weight: bold;
		    font-family: serif;
		    text-decoration: none;
		    text-shadow: 1px 1px #aaa;
		    font-size: 25pt;
		}
		article h2 a:hover {
		    color: #66a;
		}
		article {
		    border-top: 1px solid #aaa;
		}
		.meta .datetime {
		    font-size: 10pt;
		    font-style: italic;
		    color: #888;
		}
		article > h2 {
		    margin-bottom: 0px;
		}
		.meta .tags {
		    font-size: 10pt;
		    margin-left: 11px;
		    color: #888;
		}
		.meta {
		    background-color: #ddd;
		    padding: 3px 10px;
		}
	</style>
</head>
<body>

	<header>
		<h1><a href="/muflog">Muflog</a></h1>
		<h3>Your markup files blog</h3>
	</header>

	<section>
		<?php foreach ($posts as $post): ?>
			<article>
				<h2><a href="/muflog/index.php/post/<?php echo $post->name(); ?>"><?php echo $post->title(); ?></a></h2>
				<div class="meta">
					<span class="datetime"><?php echo $post->date()->format('Y-m-d H:m'); ?></span>
					<span class="tags"><?php echo implode(', ', $post->tags()); ?></span>
				</div>
				<div>
					<?php echo $post->content(); ?>
				</div>
			</article>
		<?php endforeach ?>		
	</section>

	<?php if (isset($pagination)): ?>
		<div>
			<?php if ($pagination->next()): ?>
				<a href="/muflog/index.php/<?php echo $pagination->next(); ?>">Next</a>
			<?php endif ?>

			<?php if ($pagination->prev()): ?>
				<a href="/muflog/index.php/<?php echo $pagination->prev(); ?>">Prev</a>
			<?php endif ?>			
		</div>
	<?php endif ?>	

</body>
</html>