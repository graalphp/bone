<?php
require "vendor/autoload.php";
use Graal\Bone\Engine\Skeleton;
use Graal\Bone\Parser\Html5;

$skeleton = new Skeleton();
$skeleton
    ->setBasePath(__DIR__)
    ->setTemplateDir('templates')
    ->setOutputDir('templates/out');
//var_dump($skeleton->getTemplateFullPath('partial/main'));
/*$c = Html5::class ;
var_dump($c::createFromFile());*/
$p = Html5::createFromFile('templates/main.html');
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
echo $p->getContent();


