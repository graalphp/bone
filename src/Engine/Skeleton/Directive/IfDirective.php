<?php declare(strict_types=1);
/*! Copyright (c) 2018 GraalPHP
https://github.com/graalphp

author: Ivan Maruca ( https://github.com/skullab )

Permission is hereby granted, free of charge, to any person
obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without
restriction, including without limitation the rights to use,
copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following
conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE. */
namespace Graal\Bone\Engine\Skeleton\Directive;

use Graal\Bone\Engine\Skeleton\Directive;
use Graal\Bone\Node\HtmlNode;
use Graal\Bone\Engine\Skeleton\SkeletonInterface;

class IfDirective extends Directive{

    /*public static function deleteAttributes(){
        return true ;
    }*/
    
    /*public static function deleteOptionalAttributes(){
        return true ;
    }*/

    /*public static function getOptionalAttributes(): array{
        return array();
    }*/

    public static function getAttributes():array{
        return array(
            'if'
        );
    }
    public static function transpile(array $attributes, array $optional, HtmlNode &$node,SkeletonInterface $skeleton):string{
        $inner = $node->getInnerText();
        $condition = trim($skeleton->cast($attributes['if']));
        $statement = "<?php if ($condition) { ?> $inner <?php } %%%placeholder%%% ?>" ;
        $else = $node->query('else',0);
        $else_statement = "" ;
        $else_outer = "" ;
        if($else){
            $else_inner = $else->getInnerText();
            $else_statement = "else { ?> $else_inner <?php } ";
            $else_outer = $else->getOuterText();
        }
        $statement = \str_replace($else_outer,"",\str_replace("%%%placeholder%%%",$else_statement,$statement));
        return $statement ;
    }
}