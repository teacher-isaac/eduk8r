<?php
declare(strict_types=1);
# consider using auto_prepend_file to define this globally.
define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);
require(DOCUMENT_ROOT.'/../lib/Parsedown.php');

# sets debug on/off if boolean parameter supplied
# returns value of global DEBUG variable
function debug_on($on_off) {
	if ($on_off === true)
		$_GLOBALS['DEBUG'] = true;
	else if ($on_off === false)
		$_GLOBALS['DEBUG'] = false;

	return (isset($_GLOBALS['DEBUG']) && $_GLOBALS['DEBUG'] === true);
}

function debug($msg) {
	error_log($msg);
}

function http_not_found() {
	header("HTTP/1.0 404 Not Found");
	exit;
}

function http_bad_request() {
	header("HTTP/1.0 400 Bad Request");
	exit;
}

# returns the file path to a markdown file an represented by an encoded query string
#         ?md=path:to:file => path/to/file.md or FALSE
function markdown_query_string_path() {
	if (!isset($_GET['md'])) return FALSE;
	$md = $_GET['md'];

	// validate
	if (!preg_match('/^[A-Za-z0-9_-]+(:[A-Za-z0-9_-]+)*$/', $md))
		http_bad_request();

	return str_replace(':', '/', $md).'.md';
}

# giving markdown text string, returns HTML
function markdown_text($str) {
	static $PD;
	if (!$PD) $PD = new Parsedown();

	return $PD->text($str);
}

# giving markdown filename, returns HTML string or FALSE on failure
function markdown_file($fname) {
	if (!$fname) return FALSE;
	$str = file_get_contents($fname); // return FALSE on failure
	return ($str ? markdown_text($str) : $str);
}

function print_head($data=[]) {
	if (!isset($data['meta_title'])) $data['meta_title'] = "eduk8r";
	if (!isset($data['page_title'])) $data['page_title'] = "eduk8r";

	include(DOCUMENT_ROOT."/../include/head.php");
}


function print_tail() {
	include(DOCUMENT_ROOT."/../include/tail.php");
}

# prints head
# parses markdown and prints HTML
# prints tail
function print_markdown_page($path, $data=[]) {
	# returns HTML from the mardown file given by query parameters
	$md = markdown_file($path);
	if ($md === FALSE) http_not_found(); // exits

	print_head($data);
	echo $md;
	print_tail();
}

# returns an array given a url
# * URL string with a leading '/' no containing protocol or host
#   /my/path/to/file  not  http://example.com/my/path/to/file
# * optional prefix string that will mask the url
#   (should not contain trailing '/')
# returns array or FALSE
# a url with a trailing slash will have an empty string value in the last element
function path_array($url, $prefix=FALSE) {
	if (!$url) return FALSE;

	if ($prefix) {
		if (strpos($url, $prefix) !== 0) # prefix not in url
			return FALSE; 
		$url = substr($url, strlen($prefix));  # strip prefix
	}

	if (substr($url, 0, 1) === '/') # strip leading '/'
		$url = substr($url, 1);

	if (strlen($url) === 0)
		return FALSE;

	$arr = explode('/', $url);

	if (count($arr) === 0)
		return FALSE;

	return $arr;
}

# returns <ul> list of breadcrumb links given URL
function url_breadcrumbs_list($url, $prefix=FALSE) {
	$breadcrumbs = path_array($url, $prefix);
	if (!$breadcrumbs) return FALSE;
	array_pop($breadcrumbs);
	if (count($breadcrumbs) <= 1) return FALSE;

	$ul = "<ul>";	
	$href = ($prefix ? $prefix : "");
	$i = 0;
	foreach ($breadcrumbs as $crumb) {
		//if (++$i == count($breadcrumbs)) {  // last elem
		//	$ul .= '<li><span>'.$crumb.'</span></li>';
		//} else {
			$href .= "/".$crumb;
			$ul .= '<li><a href="'.$href.'">'.$crumb.'</a></li>';
		//}
	}
	$ul .= "</ul>";

	return $ul;
}

# returns <ul> list of breadcrumb links for this requested page
function page_url_breadcrumbs_list() {
	return url_breadcrumbs_list($_SERVER['REQUEST_URI']);
}
?>
