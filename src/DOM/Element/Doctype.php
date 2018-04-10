<?php declare(strict_types=1);
namespace Graal\Bone\DOM\Element;
use Graal\Bone\Node\HtmlNodeDoctype;
class Doctype extends HtmlNodeDoctype{
    public function __construct($dtd = "HTML"){
        parent::__construct(null,$dtd);
    }
}