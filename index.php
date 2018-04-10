<?php
require "vendor/autoload.php";
use Graal\Bone\Parser\HtmlParserHtml5;
use Graal\Bone\Dom\SimplePage;
$page = new SimplePage("test");

$html = new HtmlParserHtml5($page->toString());
echo "$html\n";
