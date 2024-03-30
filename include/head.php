<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
	<title><?php echo $data['meta_title']; ?></title>
	<link href="/styles/style.css" rel="stylesheet">
	<script src="/scripts/site.js"></script>
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.15.10/styles/darcula.min.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.15.10/highlight.min.js"></script>
	<script>hljs.initHighlightingOnLoad();</script>
</head>
<body>
	<header>
		<figure class="logo">
			<a href="/"><img src="/images/logo.png" alt="eduk8r eduk8n 3ng1n"></a>
		</figure>
		<section>
			<h1><?= $data['page_title'] ?></h1>
			<nav><?php echo page_url_breadcrumbs_list(); ?></nav>
		</section>
	</header>
	<hr>
<!-- START CONTENT -->
