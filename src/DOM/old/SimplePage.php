<?php declare(strict_types=1);
namespace Graal\Bone\Dom;
use Graal\Bone\DOM\Element\Meta;
use Graal\Bone\DOM\Element\Script;
use Graal\Bone\DOM\Element\Link;
class SimplePage extends Page{

    public function __construct($title = ""){
        parent::__construct($title);
        $this->addNodeToMeta(new Meta(["charset"=>"utf-8"]));
    }
}