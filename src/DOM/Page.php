<?php declare(strict_types=1);
namespace Graal\Bone\DOM;
use Graal\Bone\Node\HtmlNode;
use Graal\Bone\DOM\Element\Doctype;
use Graal\Bone\DOM\Element\Html;
use Graal\Bone\DOM\Element\Head;
use Graal\Bone\DOM\Element\Title;
use Graal\Bone\DOM\Element\Link;
use Graal\Bone\DOM\Element\Body;
use Graal\Bone\DOM\Element\Script;
use Graal\Bone\Node\HtmlNodeConditional;

abstract class Page extends Partial{

    protected $doctype = null ;
    protected $html = null ;
    protected $head = null ;
    protected $body = null ;
    protected $title = null ;
    protected $title_str = "" ;
    protected $conditional = null ;
    protected $meta_group = [] ;
    protected $link_group = [] ;
    protected $script_group = [] ;

    function __construct($title = ""){
        parent::__construct();

        $this->title_str = $title ;
        $this->doctype = new Doctype();
        $this->html = new Html();
        $this->head = new Head();
        $this->body = new Body();
        $this->title = new Title($this->title_str);
        $this->conditional = new HtmlNodeConditional(null,"if lt IE 9");
        $this->reload();
    }
    public function addNodeToConditional(HtmlNode $node,$index = null){
        $this->conditional->addChild($node,$index);
    }
    public function addNodeToScript(HtmlNode $node,$index = null){
        $this->script_group[] = $node ;
        if($index === null){
            $this->body->addChild($node);
        }else{
            $c = (count($this->body->children) - count($this->script_group)) - 1  + $index ;
            $this->body->addChild($node,$c);
        }
    }
    public function addNodeToLink(HtmlNode $node,$index = null){
        $this->link_group[] = $node ;
        $c = $index !== null ? count($this->meta_group) + $index : count($this->meta_group) + count($this->link_group) - 1 ;
        $this->head->addChild($node,$c);
    }
    public function addNodeToMeta(HtmlNode $node,$index = null){
        $this->meta_group[] = $node ;
        $c = $index !== null ? min(count($this->meta_group) - 1,$index) : count($this->meta_group) - 1 ;
        $this->head->addChild($node,$c);
    }
    public function addNodeToHead(HtmlNode $node, $index = null){
        $this->head->addChild($node,$index);
    }
    public function addNodeToBody(HtmlNode $node,$index = null){
        $c = $index !== null ? min((count($this->body->children) - count($this->script_group)),$index) : count($this->body->children) - count($this->script_group) ;
        //$c = count($this->body->children) - count($this->script_group);
        $this->body->addChild($node,$c);
    }
    public function reload(){
        $this->clear();
        // HEAD SECTION
        foreach($this->meta_group as $meta){
            $this->head->addChild($meta);
        }
        foreach($this->link_group as $link){
            $this->head->addChild($link);
        }
        $this->head->addChild($this->conditional);
        $this->html->addChild($this->head);
        // BODY SECTION
        foreach($this->script_group as $script){
            $this->body->addChild($script);
        }
        $this->html->addChild($this->body);
        // DOCTYPE SECTION
        $this->root->addChild($this->doctype);
        // HTML SECTION
        $this->root->addChild($this->html);
    }

    public function hasNodeConditional(HtmlNode $node){
        return $this->conditional->hasChild($node);
    }
    public function hasNodeHtml(HtmlNode $node){
        return $this->html->hasChild($node);
    }
    public function hasNodeHead(HtmlNode $node){
        return $this->head->hasChild($node);
    }
    public function hasNodeBody(HtmlNode $node){
        return $this->body->hasChild($node);
    }

    public function deleteNodeFromHtml($node){
        if(\is_object($node)){
            $this->html->getChild($node)->delete();
        }else{
            $c = min(count($this->html->children) - 1,$node);
            $this->html->children[$c]->delete();
        }
    }
    public function deleteNodeFromHead($node){
        if(\is_object($node)){
            $this->head->getChild($node)->delete();
        }else{
            $c = min(count($this->head->children) - 1,$node);
            $this->head->children[$c]->delete();
        }
    }
    public function deleteNodeFromBody($node,$preserve_script = true){
        if(\is_object($node)){
            $this->body->getChild($node)->delete();
        }else{
            $c = min(($preserve_script ? (count($this->body->children) - count($this->script_group)) - 1 : (count($this->body->children) - 1)),$node);
            $this->body->children[$c]->delete();
        }
    }
    public function deleteScriptNode($node){
        $index = null ;
        if(\is_object($node)){
            foreach($this->script_group as $i => $script){
                if($script === $node){
                    $index = $i ;
                    break;
                }
            }
        }else{
            $index = $node ;
        }
        $this->body->getChild($this->script_group[$index])->delete();
        unset($this->script_group[$index]);
    }
    public function deleteLinkNode($node){
        $index = null ;
        if(\is_object($node)){
            foreach($this->link_group as $i => $link){
                if($link === $node){
                    $index = $i ;
                    break;
                }
            }
        }else{
            $index = $node ;
        }
        $this->head->getChild($this->link_group[$index])->delete();
        unset($this->link_group[$index]);
    }
    public function deleteMetaNode($node){
        $index = null ;
        if(\is_object($node)){
            foreach($this->meta_group as $i => $meta){
                if($meta === $node){
                    $index = $i ;
                    break;
                }
            }
        }else{
            $index = $node ;
        }
        $this->head->getChild($this->meta_group[$index])->delete();
        unset($this->lmeta_group[$index]);
    }
}