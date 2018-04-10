<?php declare(strict_types=1);
namespace Graal\Bone\DOM\Element;
use Graal\Bone\Node\HtmlNode;
class Html extends HtmlNode{
    public function __construct($lang = null){
        $this->setAttribute('lang',($lang ? $lang : \Locale::getPrimaryLanguage($_SERVER['HTTP_ACCEPT_LANGUAGE'])));
        parent::__construct('html',null);
    }
}