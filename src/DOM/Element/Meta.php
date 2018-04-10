<?php declare(strict_types=1);
namespace Graal\Bone\DOM\Element;
use Graal\Bone\Node\HtmlNode;
class Meta extends HtmlNode{
    public function __construct(array $attrs = [],$parent = null){
        foreach($attrs as $key => $value){
            $this->setAttribute($key,$value);
        }
        $this->self_close = true ;
        parent::__construct('meta',$parent);
    }
}