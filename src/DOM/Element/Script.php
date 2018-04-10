<?php declare(strict_types=1);
namespace Graal\Bone\DOM\Element;
use Graal\Bone\Node\HtmlNode;
class Script extends HtmlNode{
    public function __construct($src = null ,$type = "text/javascript" ,$parent = null){
        $this->setAttribute('type',$type);
        if($src !== null)$this->setAttribute("src",$src);
        parent::__construct('script',$parent);
    }
}