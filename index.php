<?php
require "vendor/autoload.php";
use Graal\Bone\Engine\Skeleton;
use Graal\Bone\Parser\Html5;

$skeleton = new Skeleton();
$skeleton
    ->setBasePath(__DIR__)
    ->setTemplateDir('templates')
    ->setOutputDir('templates/out');

$skeleton->setOutputPrefix('compiled');
$skeleton->setOutputSuffix('test');
$content = $skeleton->render("other",["myVar"=>2,'condition'=>true,'myArray'=>array(1,2,3)]);
//echo $content ;
function isFloat($value){
    return ((int)$value != $value) ;
  }
function casttype($a){
    global $skeleton ;
    var_dump($a);
    if(is_numeric($a)){
       if((int)$a != $a)return((floatval($a)));
       return intval($a);
    }
    switch(strtolower($a)){
        case 'true':return true;
        case 'false':return false;
    }
    if(strpos($a,'[') !== false || strpos($a,'array(') !== false){
        return strtoarray($a);
    }
    return $a ;
}
function strtoarray($a){
    $arr = [];
    $a = ltrim($a, '[');
    $a = ltrim($a, 'array(');
    $a = rtrim($a, ']');
    $a = rtrim($a, ')');
    var_dump($a);
    $tmpArr = explode(",", $a);
    foreach ($tmpArr as $v) {
        if(strpos($v,"=>") !== false){
            $kv = explode("=>", $v,2);
            $arr[str_replace(array('\'','"'),"",$kv[0])] = casttype(str_replace(array('\'','"'),"",$kv[1]));
        }else{
            $arr[] = casttype(str_replace(array('\'','"'),"",$v));
        }
        
    }
    return $arr;
}
var_dump(strtoarray("array('test'=>'hello',45,78.6,'other'=>true,'t'=>false,'op'=>array('test'=>false,'dsd'=>myVar))"));

/*$template = 'partial/common/main' ;
$out = $skeleton->generateOutputFilename($template);
var_dump($out);
$temp = $skeleton->retrieveOutputFilename($out);
var_dump($temp);
var_dump($skeleton->explodeOutputFilename($out));
$p = Html5::createFromFile('templates/main.html');
$t = $skeleton->transpileVar("$p");
echo $t;
$mandatory = ['for'];
$optional = ['in'] ;
$mandatory_path = implode("+",$mandatory);
var_dump($mandatory_path);
$optional_path = empty($optional) ? "" : "+$mandatory_path,".implode(",",$optional);
var_dump($optional_path);
$path = "*[$mandatory_path$optional_path]" ;
var_dump($path);
foreach ($p->query($path) as $key => $value) {
    var_dump("found ".$value->getTag());
    var_dump('MANDATORY');
    $m = array_intersect_key($value->attributes,array_fill_keys($mandatory,""));
    if(empty($m)){
        var_dump('NO MANDATORY SKIP !');
    }else{
        var_dump($m);
    }
    var_dump('OPTIONAL');
    var_dump(array_intersect_key($value->attributes,array_fill_keys($optional,"")));

}
function buffer($buf){
    return str_replace('hello','goodbye',$buf);
}
$name = 'john' ;
ob_start();
include ('templates/out/hello.php');
$content = ob_get_clean();
ob_end_flush();*/




