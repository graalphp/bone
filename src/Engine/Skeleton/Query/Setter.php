<?php declare(strict_types=1);
namespace Graal\Bone\Engine\Skeleton\Query;
use Graal\Bone\Engine\Skeleton\Query;
use Graal\Bone\Node\HtmlNode;
use Graal\Bone\Engine\Skeleton;

class Setter extends Query{
                
    function getQuery($tag):string{
        return $tag.'[set]';
    }
    function resolve(HtmlNode $node,Skeleton $skeleton):string{
        $assign = $node->getAttribute('set');
        $code = "<?php $assign ; ?>";
        return $code ;    
    }
}