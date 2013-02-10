<html>
<head>
	<title>MufLog - Page `<?php echo $page->title(); ?>`</title>
	<style type="text/css">
		body { width: 800px; margin: auto; background-color: #eee; font-family: sans-serif; }
		header { display: block; margin-top: 20px; height: 60px; }
		header h1 { padding: 0; margin: 0; font-family: serif; font-size: 40pt; }
		header h1 a { color: 000; text-decoration: none; }
		header h3 { margin: 0; padding: 0; color: #aaa; margin-top: -16px; text-shadow: 1px 1px #444; }
		article > h2 { margin-bottom: 0px; }
		article > h2 a { color: #D53C2E; font-weight: normal; font-family: serif; text-decoration: none; font-size: 37pt; text-shadow: 3px 2px 0px #EEE; }
		article > h2 a:hover { color: #66a; }
		.pagination { text-align: center; margin: 30px; font-size: 18pt; }
		.pagination a { padding: 0 20px; text-decoration: none; color: #888; }
		.pagination a:hover { color: #333; }
		.meta { background-color: #ddd; padding: 5px 10px; margin-top: -26px; text-align: right; }
		.meta .tags a { font-size: 10pt; margin-right: 11px; color: #888; }
		.meta .datetime { font-size: 10pt; font-style: italic; color: #888; }
		header .mainHeader { float: left; }
		header .contentHeader { float: right; }
		header .contentHeader h4 { font-size: 25; font-weight: normal; font-family: serif; text-shadow: 1px 1px 1px #999; }
	</style>
</head>
<body>

	<header>
		<div class="mainHeader">
			<h1><a href="<?php echo $app->config('absoluteUrl'); ?>">Muflog</a></h1>
			<h3>Your markup static files blog</h3>
		</div>
		<div class="contentHeader">
			<h4>Page `<?php echo $page->title(); ?>`</h4>
		</div>
	</header>

	<section>
		<article>
			<h2><a href="<?php echo $app->config('absoluteUrl'); ?>/page/<?php echo $page->name(); ?>"><?php echo $page->title(); ?></a></h2>
			<div>
				<?php echo $page->content(); ?>
			</div>
		</article>
	</section>

</body>
</html>