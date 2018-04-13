<?php declare(strict_types=1);
namespace Graal\Bone\Engine\Skeleton\Query;
use Graal\Bone\Node\HtmlNode;
use Graal\Bone\Engine\Skeleton;
interface QueryInterface {
    function getQuery($tag):string;
    function resolve(HtmlNode $node,Skeleton $skeleton):string;
}