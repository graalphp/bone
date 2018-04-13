<?php
require "vendor/autoload.php";
use Graal\Bone\Engine\Skeleton;
$pageName = 'hello' ;
$skeleton = new Skeleton();
$skeleton->setBasePath(__DIR__);
$skeleton->setTemplatesDir('templates');
$skeleton->setOutputDir('templates/out');
$skeleton->render($pageName,['name' => 'bone']);


