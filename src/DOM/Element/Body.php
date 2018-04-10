<?php declare(strict_types=1);
namespace Graal\Bone\DOM\Element;
use Graal\Bone\Node\HtmlNode;
class Body extends HtmlNode{
    public function __construct($parent = null){
        parent::__construct('body',$parent);
    }
}