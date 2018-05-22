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

class SwitchDirective extends Directive{

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
            'switch'
        );
    }
    public static function transpile(array $attributes, array $optional, HtmlNode &$node,SkeletonInterface $skeleton):string{
        $inner = $node->getInnerText();
        $condition = trim($skeleton->cast($attributes['switch']));
        $statement = "<?php switch($condition) { %s } ?>" ;
        $case_statement = "" ;
        $cases = $node->query('case');
        $placeholder = \count($cases);
        foreach ($cases as $case) {
            $outer_case = $case->getOuterText();
            $inner = $placeholder > 0 && $placeholder !== false ? \str_replace($outer_case,'$$$placeholder$$$',$inner) : \str_replace($outer_case,"",$inner);
            $inner_case = $case->getInnerText();
            $value = $case->getAttribute('value');
            $case_statement .= "\ncase $value: ?> $inner_case <?php ;" ;
            if($case->getAttribute('break')){
                $case_statement .= "break;";
            }
            $placeholder = false ;
        }  
        $default = $node->query('default',0);
        if($default){
            $outer_default = $default->getOuterText();
            $inner = $placeholder === 0 ? \str_replace($outer_default,'$$$placeholder$$$',$inner) : \str_replace($outer_default,"",$inner);
            $inner_default = $default->getInnerText();
            $case_statement .= "\ndefault : ?> $inner_default <?php ;";
        }         
        $statement = \str_replace('$$$placeholder$$$',\sprintf($statement,$case_statement),$inner);
        return $statement;
    }
}