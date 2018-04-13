<?php declare(strict_types=1);
namespace Graal\Bone\Engine\Skeleton\Query;
use Graal\Bone\Engine\Skeleton\Query;
use Graal\Bone\Node\HtmlNode;
use Graal\Bone\Engine\Skeleton;

class Variable extends Query{
    
    function getQuery($tag):string{
        return $tag.'[var]';
    }
    function resolve(HtmlNode $node,Skeleton $skeleton):string{
        $var = $node->getAttribute('var');
        $code = "<?php echo $var ; ?>" ;
        return $code ;
    }
}