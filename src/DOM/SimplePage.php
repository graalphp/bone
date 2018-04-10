<?php declare(strict_types=1);
namespace Graal\Bone\Dom;

use Graal\Bone\DOM\Element\Doctype;
use Graal\Bone\DOM\Element\Html;
use Graal\Bone\DOM\Element\Head;
use Graal\Bone\DOM\Element\Meta;
use Graal\Bone\DOM\Element\Title;
use Graal\Bone\DOM\Element\Link;
use Graal\Bone\DOM\Element\Body;
use Graal\Bone\DOM\Element\Script;
use Graal\Bone\Node\HtmlNodeConditional;

class SimplePage extends Page{

    protected $title_str = "" ;
    protected $conditional = null ;
    protected $meta_group = [] ;
    protected $link_group = [] ;
    protected $script_group = [] ;


    public function __construct($title = ""){
        parent::__construct();
        $this->title_str = $title ;
        $this->initialize();
        $this->resetChildren();
    }

    protected function initialize(){
        $this->doctype = new Doctype();
        $this->html = new Html();
        $this->head = new Head();
        $this->body = new Body();
        $this->title = new Title($this->title_str);
        $this->meta_group[] = new Meta(['charset' => 'utf-8']);
        $this->conditional = new HtmlNodeConditional(null,"if lt IE 9");
    }

    protected function resetChildren(){
        $this->children = array();

        $this->root->addChild($this->doctype);

        foreach($this->meta_group as $meta){
            $this->head->addChild($meta);
        }
        $this->head->addChild($this->title);
        foreach($this->link_group as $link){
            $this->head->addChild($link);
        }
        $this->head->addChild($this->conditional);

        $this->html->addChild($this->head);
        foreach($this->script_group as $script){
            $this->body->addChild($script);
        }
        $this->html->addChild($this->body);

        $this->root->addChild($this->html);
    }
}