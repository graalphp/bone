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

class IncludeDirective extends Directive{

    /*public static function deleteAttributes(){
        return true ;
    }*/
    
    /*public static function deleteOptionalAttributes(){
        return true ;
    }*/

    public static function getOptionalAttributes(): array{
        return array(
            'params'
        );
    }

    public static function getAttributes():array{
        return array(
            'include'
        );
    }
    public static function transpile(array $attributes, array $optional, HtmlNode &$node,SkeletonInterface $skeleton):string{
       $template = $attributes['include'];
       var_dump($optional['params']);
       //$params = isset($optional['params']) && ($param = json_decode(str_replace("'","\"",$optional['params']),true)) ? $param : [] ;
       // :\s*(?!'|")((\w*\.?\[?[\'\"]?\w[\'\"]?\]?)+)

       if(isset($optional['params'])){
            $optional['params'] = \preg_replace_callback('/:\s*(?!\'|\")((\w*\.?\[?\(?[\'\"]?\w[\'\"]?\)?\]?)+)/',function($matches){
                var_dump($matches[1]);
                $matches[1] = \addslashes($matches[1]);
                if(is_numeric($matches[1])){
                    return $matches[0];
                }
                if(\strtolower($matches[1]) == 'true' || \strtolower($matches[1]) == 'false'){
                    return $matches[0];
                }
                return ":'$matches[1]'";
            },$optional['params']);
        }
      /* foreach ($params as $key => $value) {
           if(\array_key_exists($value,$skeleton->extracted_params)){
                $params[$key] = $skeleton->extracted_params[$value] ;
           }
       }*/
       var_dump($optional['params']);
       $params = (isset($optional['params']) && $params = json_decode(str_replace("'","\"",$optional['params']),true)) ? $params : [] ;
       var_dump($params);
       foreach ($params as $key => $value) {
           if(\is_string($value)){
               $obj = \explode(".",$value);
               var_dump($obj);
                if(\array_key_exists($obj[0],$skeleton->extracted_params)){
                    $params[$key] = $skeleton->extracted_params[$obj[0]];
                    $root = $skeleton->extracted_params[$obj[0]];
                    for($i = 1 ; $i < count($obj) ; $i++) {
                        var_dump($root);
                        if(\strpos($obj[$i],"[") !== false){
                            $arr = \explode("[",$obj[$i]);
                            $aName = $arr[0];
                            $aRef = \str_replace(array("'","\""),"", \rtrim($arr[1],']'));
                            $root = $root->{$aName}[$aRef];
                        }else{
                            $root = $root->{$obj[$i]};
                        }
                        $params[$key] = $root;
                        
                    }
                }
           }
           
       }
       var_dump($params);
       var_dump($skeleton->extracted_params);
       return $skeleton->render($template,$params);;         
    }
}