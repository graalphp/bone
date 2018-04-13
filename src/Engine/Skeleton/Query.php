<?php declare(strict_types=1);
namespace Graal\Bone\Engine\Skeleton;
use Graal\Bone\Engine\Skeleton\Query\QueryInterface;
use Graal\Bone\Node\HtmlNode;
use Graal\Bone\Engine\Skeleton;
abstract class Query implements QueryInterface{
    abstract function getQuery($tag):string;
    abstract function resolve(HtmlNode $node,Skeleton $skeleton):string;
}