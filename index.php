<?php
require "vendor/autoload.php";
use Graal\Bone\Parser\HtmlParserHtml5;
use Graal\Bone\DOM\Partial;
use Graal\Bone\DOM\Page;
use Graal\Bone\DOM\SimplePage;
use Graal\Bone\Node\HtmlNode;

$page = Page::createFromFile("template.html");
$page->query("#content",0)->setInnerText("Hello Bone !");
//$html = new HtmlParserHtml5($page->toString());
//echo "$html\n";

echo "$page\n";
