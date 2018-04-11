<?php declare(strict_types=1);
namespace Graal\Bone\DOM;
use Graal\Bone\Node\HtmlNode;
use Graal\Bone\Parser\HtmlParserHtml5;

class Partial {

    protected $root = null ;
    protected $parser = null ;

    function __construct(HtmlNode $root = null){
        $this->root = $root !== null ? $root : new PageNode();
        $this->parser = new HtmlParserHtml5($this->root->getInnerText());
    }
    public function addNode(HtmlNode $node,$index = null){
        $this->root->addChild($node,$index);
    }
    public function deleteNode($node){
        $this->root->deleteChild($node);
    }
    public function clear(){
        $this->root->clear();
    }
    public function __toString(){
        if($this->root instanceof PageNode){
            return $this->root->toString();
        }else{
            return "$this->parser\n";
        }
    }
    public function query($q,$index = false){
        return $this->parser->select($q,$index);
    }
    public function toString(){
        return $this->__toString();
    }

    public static function createFromString($html){
        $parser = new HtmlParserHtml5($html);
        return new self($parser->root);
    }

    public static function createFromFile($filename, $use_include_path = false, $context = null){
        $f = \file_get_contents($filename,$use_include_path,$context);
        return (($f === false) ? null : self::createFromString($f));
    }
}