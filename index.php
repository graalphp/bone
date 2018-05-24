<?php
require "vendor/autoload.php";
use Graal\Bone\Engine\Skeleton;
use Graal\Bone\Parser\Html5;

$obj = new stdClass();
$obj->x = new stdClass() ;
$obj->x->y = ['eureka'];
$obj->x->z = function(){ return 'yeah' ;};
$obj->arr = ['x'=>'array x'];

$skeleton = new Skeleton();
$skeleton
    ->setBasePath(__DIR__)
    ->setTemplateDir('templates')
    ->setOutputDir('templates/out');

$skeleton->setOutputPrefix('compiled');
$skeleton->setOutputSuffix('test');
$content = $skeleton->render("other",
["myVar"=>2,'condition'=>true,'myArray'=>array("<b>ciao</b>"),'obj'=>$obj,'name'=>'jo']);
echo $content ;

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




