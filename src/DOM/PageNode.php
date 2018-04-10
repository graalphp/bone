<?php declare(strict_types=1);
namespace Graal\Bone\DOM;
use Graal\Bone\Node\HtmlNode;
class PageNode extends HtmlNode{
    var $tag = 'page' ;
    function __construct(){
        parent::__construct($this->tag,null);
    }
    public function toString($attributes = true, $recursive = true, $content_only = false){
        return $this->toString_content($attributes,$recursive,$content_only);
    }
}