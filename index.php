<?php
require "vendor/autoload.php";
use Graal\Bone\Parser\HtmlParserHtml5;
use Graal\Bone\DOM\Partial;
use Graal\Bone\DOM\Page;
use Graal\Bone\DOM\SimplePage;
use Graal\Bone\Node\HtmlNode;
use Graal\Bone\Node\HtmlNodeText;
use Graal\Bone\Node\HtmlNodeEmbedded;
use Graal\Bone\DOM\Element\Script;

$page = Page::createFromFile("templates/main.html");
//$page = new Page();
//$page->setTitleText("test");
//$page->getHtmlNode()->setAttribute("lang","it");
/*var_dump($page->query("?php"));
$var = $page->query("bone[var]",0);
$parent = $var->parent ;
$parent->children[$var->index()] = new HtmlNodeText(null,"John");*/
$name = 'John' ;

foreach ($page->query("bone[var]") as $bone) {
    $var = $bone->getAttribute('var');
    $code = "<?php echo $var ; ?>" ;
    $bone->setOuterText($code);
}
foreach ($page->query("bone[for]") as $bone) {
    $statement = $bone->getAttribute('for');
    $inner = $bone->getInnerText();
    $code = "<?php for($statement) { ?> $inner <?php } ?>" ;
    $bone->setOuterText($code);
}

$bone = $page->query("bone[if]")[0];
$condition = $bone->getAttribute("if") ;
$inner = $bone->getInnerText();
$code = "<?php if($condition){ ?> $inner <?php } ?>" ;
$bone->setOuterText($code);

file_put_contents("templates/main.bone.php",$page->getContent());
include("templates/main.bone.php");
//echo $page->getContent();

//echo "$page\n";
