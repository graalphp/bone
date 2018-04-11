<?php declare(strict_types=1);
namespace Graal\Bone\DOM;

use Graal\Bone\DOM\Element\Doctype;
use Graal\Bone\DOM\Element\Html;
use Graal\Bone\DOM\Element\Head;
use Graal\Bone\DOM\Element\Title;
use Graal\Bone\DOM\Element\Link;
use Graal\Bone\DOM\Element\Body;
use Graal\Bone\DOM\Element\Script;

use Graal\Bone\Node\HtmlNode;
use Graal\Bone\Node\HtmlNodeConditional;
use Graal\Bone\Node\HtmlNodeDoctype;
use Graal\Bone\Node\HtmlNodeEmbedded;

class Page extends Partial{

    protected $doctype = null ;
    protected $html = null ;
    protected $head = null ;
    protected $body = null ;
    protected $title = null ;
    protected $title_str = "" ;
    protected $conditional = null ;

    protected $meta_group = null ;
    protected $link_group = null ;
    protected $script_group = null ;

    protected $options = [
        "doctype"       => "html" ,
        "title"         => "" ,
        "conditional"   => "if IE"
    ] ;

    public function __construct(HtmlNode $node = null, $options = []){
        parent::__construct($node);
        $this->setOptions($options);
        $this->initialize();
    }
    protected function initialize(){

        $this->setDoctypeNode(($this->root->select('"!DOCTYPE"',0) !== null ) ? 
                        $this->query('"!DOCTYPE"',0) : new Doctype($this->options['doctype']));

        $this->setHtmlNode(($this->root->select("html",0) !== null) ? 
                        $this->query("html",0) : new Html());
        $this->setHeadNode(($this->html->select("head",0) !== null ? 
                        $this->query("head",0) : new Head()));
        $this->setTitleNode(($this->head->select("title",0) !== null ?
                        $this->query("title",0) : new Title($this->options['title'])));

        $this->meta_group = [] ;
        foreach ($this->query("meta") as $meta) {
            $this->meta_group[] = $meta ;
        }

        $this->link_group = [] ;
        foreach ($this->query("link") as $link) {
            $this->link_group[] = $link ;
        }

        foreach($this->query("*") as $node){
            if($node instanceof HtmlNodeConditional){
                $this->conditional = $node ;
                break;
            }
        }

        if($this->conditional === null){
            $this->conditional = new HtmlNodeConditional(null,$this->options['conditional']);
        }

        $this->setBodyNode(($this->root->select("body",0) !== null) ? 
                        $this->query("body",0) : new Body());

        $this->script_group = [] ;
        foreach($this->query("script") as $script){
            $this->script_group[] = $script ;
        }
    }
    public function setDoctypeNode(HtmlNodeDoctype $doctype){
        $this->doctype = $doctype ;
    }
    public function getDoctypeNode(){
        return $this->doctype ;
    }
    public function setHtmlNode(HtmlNode $html){
        $this->html = $html ;
    }
    public function getHtmlNode(){
        return $this->html ;
    }
    public function setHeadNode(HtmlNode $head){
        $this->head = $head ;
    }
    public function getHeadNode(){
        return $this->head ;
    }
    public function setBodyNode(HtmlNode $body){
        $this->body = $body ;
    }
    public function getBodyNode(){
        return $this->body ;
    }
    public function setTitleNode(HtmlNode $title){
        $this->title = $title ;
    }
    public function getTitleNode(){
        return $this->title;
    }
    public function setConditionalNode(HtmlNodeConditional $conditional){
        $this->conditional = $conditional ;
    }
    public function getConditionalNode(){
        return $this->conditional;
    }
    public function setTitleText($text){
        return $this->title->setInnerText($text,$this->parser);
    }
    public function getTitleText(){
        return $this->title->getInnerText();
    }
    public function getLinkGroup(){
        return $this->link_group ;
    }
    public function getMetaGroup(){
        return $this->meta_group ;
    }
    public function getScriptGroup(){
        return $this->script_group ;
    }
    public function setOptions(array $options){
        $this->options = array_merge($this->options,array_intersect_key($options,$this->options));
    }
    public function getOption($name){
        return (isset($this->options[$name])) ? $this->options[$name] : null ;
    }
    public function setContent($content){
        $this->root->setInnerText($content,$this->parser);
    }
    public function getContent(){
        return $this->root->getInnerText();
    }
}