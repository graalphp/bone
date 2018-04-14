<?php declare(strict_types=1);
namespace Graal\Bone\Parser;
use Graal\Bone\Formatter\HtmlFormatter;

class Html5 extends HtmlParserHtml5{

    public static function createFromFile($filename,$return_root = false, $use_include_path = false, $context = null){
        if(\file_exists($filename)){
            $f = file_get_contents($filename, $use_include_path, $context);
            $h = new Html5($f);
            return ($return_root) ? $h->root : $h ;
        }else{
            throw new \Exception("The \"$filename\" file does not exist",1);
        }
    }
    function query($query = '*', $index = false, $recursive = true, $check_self = false){
		return $this->root->select($query,$index,$recursive,$check_self);
	}
    public function minifyHtml($strip_comments = true, $recursive = true){
        return HtmlFormatter::minify_html($this->root,$strip_comments,$recursive);
    }
    public function minifyJS($indent_string = ' ', $wrap_comment = true, $recursive = true){
        return HtmlFormatter::minify_javascript($this->root,$indent_string,$wrap_comment,$recursive);
    }
    public function formatHtml(array $options = []){
        $f = new HtmlFormatter($options);
        return $f->format($this->root);
    }
    public function getContent():string{
        return $this->root->getInnerText();
    }
}