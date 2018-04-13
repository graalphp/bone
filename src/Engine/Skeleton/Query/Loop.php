<?php declare(strict_types=1);
namespace Graal\Bone\Engine\Skeleton\Query;
use Graal\Bone\Engine\Skeleton\Query;
use Graal\Bone\Node\HtmlNode;
use Graal\Bone\Engine\Skeleton;

class Loop extends Query{
                
    function getQuery($tag):string{
        return $tag.'[for]';
    }
    function resolve(HtmlNode $node,Skeleton $skeleton):string{
        $statement = $node->getAttribute('for');
        $inner = $node->getInnerText();
        $code = "<?php for($statement) { ?> $inner <?php } ?>" ; 
        return $code ;
    }
}