<?php declare(strict_types=1);
namespace Graal\Bone\DOM;
Use Graal\Bone\Node\HtmlNode;
use Graal\Bone\Parser\HtmlParserHtml5 as Parser;
class Partial {

    protected $root = null ;
    protected $parser = null ;

    public function __construct(HtmlNode $node = null){
        $this->root = ($node === null) ? new HtmlNode('~root~', null) : $node ;
        $this->parser = new Parser($this->root->getInnerText());
    }
    public function &getRoot(){
        return $this->root ;
    }
    function __toString() {
		return $this->root->getInnerText();
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

    public function query($q,$index = false){
        return $this->root->select($q,$index);
    }
    public function contains($q,$text){
        $r = [] ;
        foreach ($this->query($q) as $node) {
            if(\strpos($node->getPlainText(),$text) !== FALSE){
                $r[] = $node ;
            }
        }
        return $r ;
    }
    
    public static function createFromString($html){
        $class = \get_called_class();
        $parser = new Parser($html);
        return new $class($parser->root);
    }
    public static function createFromFile($filename, $use_include_path = false, $context = null){
        $f = \file_get_contents($filename,$use_include_path,$context);
        return (($f === false) ? null : self::createFromString($f));
    }
}