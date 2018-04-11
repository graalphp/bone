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
use Graal\Bone\Formatter\HtmlFormatter;

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
foreach ($page->query("bone[if]") as $bone) {
    $condition = $bone->getAttribute("if") ;
    $inner = $bone->getInnerText();
    $code = "<?php if($condition){ ?> $inner <?php }" ;
    
    $next = $bone->getNextSibling();
    if($next->getTag() === 'bone' && ($next->hasAttribute('else') || $next->hasAttribute('elseif'))){
        $else_condition = $next->hasAttribute('elseif') ? $next->getAttribute('elseif') : "" ;
        $else_inner = $next->getInnerText();
        $code .= $next->hasAttribute('elseif') ? "elseif($else_condition) { ?> $else_inner <?php } ?>" : "else { ?> $else_inner <?php } ?>";
        $next->delete();
    }else{
        $code .= " ?>";
    }

    $bone->setOuterText($code);
}

//clear
foreach ($page->query('bone') as $bone) {
    $bone->delete();
}
$formatter = new HtmlFormatter();
$formatter->format($page->getRoot());
file_put_contents("templates/main.bone.php",$page->getContent());
include("templates/main.bone.php");
//echo $page->getContent();

//echo "$page\n";
