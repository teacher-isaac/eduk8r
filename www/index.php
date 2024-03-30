<?php
# prints head
# parses markdown and prints HTML
# prints tail

require($_SERVER['DOCUMENT_ROOT']."/../include/init.php");

print_markdown_page(
	"index.md",
	[
		'meta_title' => 'Homepage',
		'page_title' => 'Homepage'
	]
);
?>
