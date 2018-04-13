<?php declare(strict_types=1);
namespace Graal\Bone\Engine\Skeleton\Query;
use Graal\Bone\Engine\Skeleton\Query;
use Graal\Bone\Node\HtmlNode;
use Graal\Bone\Engine\Skeleton;

class Inclusion extends Query{
                
    function getQuery($tag):string{
        return $tag.'[include]';
    }
    function resolve(HtmlNode $node,Skeleton $skeleton):string{
        $template = $node->getAttribute('include');
        return $skeleton->getContent($template);
    }
}