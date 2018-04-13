<?php declare(strict_types=1);
namespace Graal\Bone\Engine\Skeleton\Query;
use Graal\Bone\Engine\Skeleton\Query;
use Graal\Bone\Node\HtmlNode;
use Graal\Bone\Engine\Skeleton;

class Conditional extends Query{
    protected $lastTag = "" ;

    function getQuery($tag):string{
        $lastTag = $tag ;
        return $tag.'[if]';
    }
    function resolve(HtmlNode $node,Skeleton $skeleton):string{
        $condition = $node->getAttribute("if") ;
        $inner = $node->getInnerText();
        $code = "<?php if($condition){ ?> $inner <?php }" ;

        $next = $node->getNextSibling();
        $code .= $this->checkElseIf($next) . $this->checkElse($next) . "?>";
        return $code ;
    }
    protected function checkElse(HtmlNode $next,$code = ""){
        if($next->getTag() === $this->lastTag && $next->hasAttribute('else')){
            $else_inner = $next->getInnerText();
            $code = "else { ?> $else_inner <?php } " ;
        }
        return $code ;
    }
    protected function checkElseIf(HtmlNode $next,$code = "",$continue = false){
        if($next->getTag() === $this->lastTag && $next->hasAttribute('elseif')){
            $else_condition = $next->getAttribute('elseif');
            $else_inner = $next->getInnerText();
            $code .= "elseif() { ?> $else_inner <?php }";
            $continue = true ;
        }
        return ($continue ? $this->checkElseIf($next->getNextSibling(),$code) : $code );
    }
    
}