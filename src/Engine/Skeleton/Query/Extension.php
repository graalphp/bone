<?php declare(strict_types=1);
namespace Graal\Bone\Engine\Skeleton\Query;
use Graal\Bone\Engine\Skeleton\Query;
use Graal\Bone\Node\HtmlNode;
use Graal\Bone\Engine\Skeleton;
use Graal\Bone\DOM\Page;

class Extension extends Query{
    
    protected $lastTag = "";

    function getQuery($tag):string{
        return $tag.'[extends]';
    }
    function resolve(HtmlNode $node,Skeleton $skeleton):string{
        $template = $node->getAttribute('extends');
        $content = $skeleton->getContent($template);
        $page = Page::createfromString($content);
        
        foreach ($page->query($this->lastTag.'[block]') as $extNode) {
            $blockName = $extNode->getAttribute('block') ;
            $block = $node->select($this->lastTag."[block=$blockName]",0);
            if($block != null)$extNode->setOuterText($block->getInnerText());
        }
        return $page->getContent();
    }
}