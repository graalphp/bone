<?php declare(strict_types=1);
namespace Graal\Bone\Engine\Skeleton\Query;
use Graal\Bone\Engine\Skeleton\Query;
use Graal\Bone\Node\HtmlNode;
use Graal\Bone\Engine\Skeleton;

class Loopeach extends Query{
                
    function getQuery($tag):string{
        return $tag.'[foreach]';
    }
    function resolve(HtmlNode $node,Skeleton $skeleton):string{
        $statement = $node->getAttribute('for');
        $inner = $node->getInnerText();
        $code = "<?php foreach($statement) { ?> $inner <?php } ?>" ; 
        return $code ;       
    }
}