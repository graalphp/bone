<?php declare(strict_types=1);
namespace Graal\Bone\DOM\Element;
use Graal\Bone\Node\HtmlNode;
class Link extends HtmlNode{
    public function __construct($href,$rel = "stylesheet" , $parent = null){
        $this->setAttribute('rel',$rel);
        $this->setAttribute('href',$href);
        $this->self_close = true ;
        parent::__construct('link',$parent);
    }
}