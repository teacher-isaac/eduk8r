<?php
# prints head
# parses markdown and prints HTML
# prints tail

include($_SERVER['DOCUMENT_ROOT']."/../include/init.php");

$md_path = "index.md";
if (isset($_GET['md']))
	$md_path = markdown_query_string_path();

print_markdown_page(
	$md_path,
	[
		'meta_title' => '🐧 Linux Resources',
		'page_title' => '🐧 Linux Resources',
	]
);
?>
