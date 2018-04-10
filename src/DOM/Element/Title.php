<?php declare(strict_types=1);
namespace Graal\Bone\DOM\Element;
use Graal\Bone\Node\HtmlNode;
class Title extends HtmlNode{
    public function __construct($title = '',$parent = null){
        $this->setInnerText($title);
        parent::__construct('title',$parent);
    }
}