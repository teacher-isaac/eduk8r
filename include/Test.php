<?php
use PHPUnit\Framework\TestCase;

require("init.php");

class Test extends TestCase
{
    public function test_path_array()
    {
        $stack = [];
        $this->assertSame(path_array(""), FALSE);
        $this->assertSame(path_array("/"), FALSE);
        $this->assertSame(path_array("/path/to", "path/to"), FALSE);
        $this->assertSame(path_array("/path/to", "/oops/to"), FALSE);

        $this->assertSame(path_array("/path/to"), ["path", "to"]);
        $this->assertSame(path_array("path/to"), ["path", "to"]);
        $this->assertSame(path_array("/priv/path/to", "/priv"), ["path", "to"]);
        $this->assertSame(path_array("/priv/path/to", "priv"), FALSE);
	$this->assertSame(path_array("/priv/path/to", "/not/even/close"), FALSE);
	$this->assertSame(path_array("/~user/path/to", "/~user"), ["path", "to"]);
    }

    public function test_url_breadcrumbs_list()
    {
        $stack = [];
        $this->assertSame(url_breadcrumbs_list(""), FALSE);
        $this->assertSame(url_breadcrumbs_list("/"), FALSE);
        $this->assertSame(url_breadcrumbs_list("/path/to", "path/to"), FALSE);
        $this->assertSame(url_breadcrumbs_list("/path/to", "/oops/to"), FALSE);

        $this->assertSame(url_breadcrumbs_list("/path/to"), "<ul><li>path</li><li>to</li></ul>");
        $this->assertSame(url_breadcrumbs_list("path/to"), "<ul><li>path</li><li>to</li></ul>");
        $this->assertSame(url_breadcrumbs_list("/priv/path/to", "/priv"), "<ul><li>path</li><li>to</li></ul>");
        $this->assertSame(url_breadcrumbs_list("/priv/path/to", "priv"), FALSE);
	$this->assertSame(url_breadcrumbs_list("/priv/path/to", "/not/even/close"), FALSE);
	$this->assertSame(url_breadcrumbs_list("/~user/path/to", "/~user"), "<ul><li>path</li><li>to</li></ul>");
    }
}
