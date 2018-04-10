<?php declare(strict_types=1);
namespace Graal\Bone\DOM;
use Graal\Bone\Node\HtmlNode;
abstract class Page{
    protected $root = null ;

    public $doctype = null ;
    public $html = null ;
    public $head = null ;
    public $body = null ;
    public $title = null ;

    function __construct(){
        $this->root = new PageNode();
    }

    public function __toString(){
        return $this->root->toString();
    }
    public function toString(){
        return $this->__toString();
    }
}