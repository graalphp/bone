<?php declare(strict_types=1);
namespace Graal\Bone\Engine;
use Graal\Bone\Engine\Skeleton\Query\QueryInterface;
use Graal\Bone\DOM\Page;

class OLD_Skeleton implements TemplateEngineInterface{

    protected $defaultTag = '' ;
    protected $tagList = [] ;
    protected $templatesDir = '' ;
    protected $outputDir = '' ;
    protected $basePath = '' ;
    protected $allowedExts = ['.html','.bone.html'] ;
    protected $queries = [] ;

    function __construct($templatesDir = '',$outputDir = '',$defaultTag = 'bone'){
        $this->templatesDir = $templatesDir ;
        $this->outputDir = $outputDir ;
        $this->defaultTag = $defaultTag ;
        $this->addTag($this->defaultTag);
        $this->initialize();
    }
    protected function initialize(){
        $this->addQuery(new Skeleton\Query\Inclusion());
        $this->addQuery(new Skeleton\Query\Extension());
        $this->addQuery(new Skeleton\Query\Setter());
        $this->addQuery(new Skeleton\Query\Variable());
        $this->addQuery(new Skeleton\Query\Loop());
        $this->addQuery(new Skeleton\Query\Loopeach());
        $this->addQuery(new Skeleton\Query\Conditional());
    }
    function addQuery(QueryInterface $query){
        $this->queries[] = $query ;
    }
    function getContent(string $template,$clear = false):string{
        $page = null ;
        foreach ($this->allowedExts as $ext) {
            $file = $this->path($template.$ext);
            if(\file_exists($file)){
                $page = Page::createFromFile($file);
                break;
            }
        }
        if(!$page){
            $page = Page::createFromString($template);
        }
        foreach($this->tagList as $tag){
            foreach ($this->queries as $query) {

                $nodes = $page->query($query->getQuery($tag));
                for($i = count($nodes) - 1  ; $i >= 0 ; $i--){
                    $code = $query->resolve($nodes[$i],$this);
                    $nodes[$i]->setOuterText($code);
                }
                /*foreach($page->query($query->getQuery($tag)) as $node){
                    $code = $query->resolve($node,$this);
                    $node->setOuterText($code);
                }*/
            }
        }
        if($clear)$this->clearTags($page);
        return $page->getContent();
    }
    function render(string $template,array $params = []){
        if(!empty($params))extract($params);
        file_put_contents($this->pathOut($template),$this->getContent($template,true));
        ob_start();
        include($this->pathOut($template));
        ob_end_flush();
    }
    protected function clearTags($page){
        foreach($this->tagList as $tag){
            foreach($page->query($tag) as $node){
                $node->delete();
            }
        }
    }
    function pathOut(string $template):string{
        return ($this->getBasePath().
                DIRECTORY_SEPARATOR.
                $this->getOutputDir().
                DIRECTORY_SEPARATOR.
                $template.'.php');
    }
    function path(string $template):string{
        return ($this->getBasePath().
                DIRECTORY_SEPARATOR.
                $this->getTemplatesDir().
                DIRECTORY_SEPARATOR.
                $template);
    }
    function setBasePath(string $path){
        $this->basePath = $path ;
    }
    function getBasePath():string{
        return $this->basePath ;
    }
    function setDefaultTag(string $tag){
        $this->tagDefault = $tag;
    }
    function getDefaultTag():string{
        return $this->tagDefault ;
    }
    function addTag(string $tag){
        $this->tagList[] = $tag ;
    }
    function removeTag(string $tag):boolean{
        foreach ($this->tagList as $key => $value) {
            if($value === $tag){
                array_splice($this->tagList,$key,1);
                return true ;
            }
        }
        return false ;
    }
    function setTemplatesDir(string $path){
        $this->templatesDir = $path ;
    }
    function getTemplatesDir():string{
        return $this->templatesDir ;
    }
    function setOutputDir(string $path){
        $this->outputDir = $path;
    }
    function getOutputDir():string{
        return $this->outputDir ;
    }
}