<?php declare(strict_types=1);
namespace Graal\Bone\DOM\Element;
use Graal\Bone\Node\HtmlNode;
class Head extends HtmlNode{
    public function __construct(){
        parent::__construct('head',null);
    }
}