<?php declare (strict_types = 1);
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

namespace Graal\Bone\Engine;
use Graal\Bone\Parser\Html5;
use Graal\Bone\Engine\Skeleton\SkeletonException;
use Graal\Bone\Engine\SKeleton\SkeletonInterface;
use Graal\Bone\Engine\Skeleton\Directive\IfDirective;
use Graal\Bone\Engine\Skeleton\Directive\ForDirective;
use Graal\Bone\Engine\Skeleton\Directive\SwitchDirective;
use Graal\Bone\Engine\Skeleton\Directive\IncludeDirective;

class Skeleton implements SkeletonInterface {

    protected $escapeVarSymbol = "#";
    protected $escapeExpSymbol = "#";
    protected $regexVar = '/#?{{\s*(.*?)\s*}}/';
    protected $regexExp = '/#?{%\s*(.*?)\s*%}/';
    protected $basePath;
    protected $templateDir;
    protected $outputDir;
    protected $outputPrefix;
    protected $outputSuffix;
    protected $templateFullPath;
    protected $outputFullPath;
    protected $expiresOutputFilename = 60 * 60;
    protected $renderStarted = false ;

    protected $globals = [

    ];
    public $extracted_params = [] ;

    protected $functions = [
        'str_replace'=>'str_replace'
    ];
    protected $directives = [
        ForDirective::class,
        IfDirective::class,
        SwitchDirective::class,
        IncludeDirective::class,
    ];
    protected $options = [
        'DIR_SEPARATOR' => '$',
        'OUTPUT_SEPARATOR' => '.',
        'GENERATE_OUT_DATE' => false,
        'GENERATE_EXPIRE_OUT_DATE' => false,
        'CACHE_ENABLED' => false,
        'VAR_STYLE_PHP' => false,
    ];
    protected $fileExts = [
        '.html',
        '.bone',
        '.bone.html',
        '.html.bone',
        '.css',
    ];
    protected $exclusiveTags = [
        'bone',
    ];
    /**
     *
     */
    public function __construct() {
        $this->functions['escape'] = function($v){
            return htmlspecialchars($v, ENT_QUOTES);
        };
    }

    /**
     *
     * @return string
     */
    public function compile(Html5 $parser): string {
        # compile the template
        foreach ($this->directives as $directive) {

            $mandatory = $directive::getAttributes();
            $optional = $directive::getOptionalAttributes();
            $mandatory_path = implode("+", $mandatory);
            $optional_path = empty($optional) ? "" : "+$mandatory_path," . implode(",", $optional);
            $path = "*[$mandatory_path$optional_path]";

            foreach (\array_reverse($parser->query($path)) as $node) {
                
                $attrs = array_intersect_key(\array_change_key_case($node->attributes), array_fill_keys($mandatory, ""));
                $op = array_intersect_key(\array_change_key_case($node->attributes), array_fill_keys($optional, ""));
                $traspiled = $directive::transpile($attrs, $op, $node, $this);

                if (\in_array($node->getTag(), $this->exclusiveTags)) {
                    $node->setOuterText($traspiled);
                } else {

                    if ($directive::deleteAttributes() !== false) {
                        $da = \is_array($directive::deleteAttributes()) ? $directive::deleteAttributes() : $mandatory;
                        foreach ($da as $attr) {
                            $node->deleteAttribute($attr);
                        }
                    }

                    if ($directive::deleteOptionalAttributes() !== false) {
                        $oa = \is_array($directive::deleteOptionalAttributes()) ? $directive::deleteOptionalAttributes() : $optional;
                        foreach ($oa as $attr) {
                            $node->deleteAttribute($attr);
                        }
                    }

                    $node->setInnerText($traspiled);
                }
            }
        }
        # return the content
        return $this->transpileVar($parser->getContent());
    }

    /**
     * Undocumented function
     *
     * @param string $template
     * @return string
     */
    public function transpileVar(string $template): string {
        if (\preg_match_all($this->regexVar, $template, $matches) !== FALSE) {
            $this->escapeVar($matches);
            $template = \str_replace($matches[0], \array_map(array($this, 'outVar'), $matches[1]), $template);
        }
        if (\preg_match_all($this->regexExp, $template, $matches) !== FALSE) {
            $template = \str_replace($matches[0], \array_map(array($this, 'outExp'), $matches[1]), $template);
        }
        return $template;
    }

    public function escapeVar(array &$matches): array{
        foreach ($matches[0] as $key => $value) {
            if (\substr($value, 0, 1) == $this->escapeVarSymbol) {
                $matches[1][$key] = "'" . \addslashes(\substr($value, 1)) . "'";
            }
        }
        return $matches;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function start() {
        if(!$this->renderStarted){
            $this->renderStarted = true ;
            @ob_start();
        }
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function end() {
        if($this->renderStarted){
            $this->renderStarted = false ;
            if(\ob_get_length()){
                \ob_end_flush();
            }
        }
    }
    /**
     *
     */
    public function render(string $template, array $params = []): string {
        if (($filename = $this->templateExists($template)) === false) {
            throw new SkeletonException("The template \"$template\" file does not exist", 1);
        }
        foreach ($params as $key => $value) {
            $this->extracted_params[$key] = $value ;
        }
        
        /* TODO LIST */
        # check for cached template     |
        # OR
        # compile the template          |
        # put in output file            | > function compile()
        $content = $this->compile(Html5::createFromFile($this->getTemplateFullPath($filename)));
        $outputPath = $this->getOutputFullPath($this->generateOutputFilename($template));
        if (\file_put_contents($outputPath, $content) === FALSE) {
            throw new SkeletonException("Error on generating template", 1);
        };
        # start render                  | > function start()
        $this->start();
        # extract params                |
        if (!empty($params)) {
            \extract($params);
        }
        # extract globals params        | > function extractCommon();
        # extract functions             |
        if (!empty($this->functions)) {
            \extract($this->functions);
        }
        # include output file           |
        # get content of output file    |> function getCompiledTemplateContent();
        include $outputPath;
        $content = \ob_get_clean();
        # end render                    |> function end()
        $this->end();
        # return $content ;
        return $content;

    }

    /**
     *
     */
    public function templateExists(string $template) {
        foreach ($this->fileExts as $ext) {
            if (file_exists($this->getTemplateFullPath($template . $ext))) {
                return ($template . $ext);
            }
        }
        return false;
    }

    /**
     * Get the value of basePath
     */
    public function getBasePath(): string {
        return $this->basePath;
    }

    /**
     * Set the value of basePath
     *
     * @return  self
     */
    public function setBasePath($basePath): self{
        $this->basePath = $basePath;

        return $this;
    }

    /**
     * Get the value of templateDir
     */
    public function getTemplateDir(): string {
        return $this->templateDir;
    }

    /**
     * Set the value of templateDir
     *
     * @return  self
     */
    public function setTemplateDir($templateDir): self{
        $this->templateFullPath = null;
        $this->templateDir = $templateDir;

        return $this;
    }

    /**
     * Get the value of outputDir
     *
     * @return string
     */
    public function getOutputDir(): string {
        return $this->outputDir;
    }

    /**
     * Set the value of outputDir
     *
     * @return  self
     */
    public function setOutputDir($outputDir): self{
        $this->outputFullPath = null;
        $this->outputDir = $outputDir;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getTemplateFullPath(string $template = ""): string {
        if ($this->templateFullPath == null) {
            $this->templateFullPath =
                (($this->basePath != null) ? rtrim($this->basePath, '\/') . '/' : "") .
                (($this->templateDir != null) ? rtrim($this->templateDir, '\/') . '/' : "");
        }
        return $this->templateFullPath . $template;

    }

    /**
     *
     * @return string
     */
    public function getOutputFullPath(string $template = ""): string {
        if ($this->outputFullPath == null) {
            $this->outputFullPath =
                (($this->basePath != null) ? rtrim($this->basePath, '\/') . '/' : "") .
                (($this->outputDir != null) ? rtrim($this->outputDir, '\/') . '/' : "");
        }
        return $this->outputFullPath . $template;
    }

    /**
     * Get the value of options
     *
     * @return array
     */
    public function getOptions(): array{
        return $this->options;
    }

    /**
     * Set the value of options
     *
     * @return  self
     */
    public function setOptions(array $options): self{
        $this->options = \array_merge($this->options, \array_intersect_key($options, $this->options));

        return $this;
    }

    /**
     * Set the single value of options
     *
     * @return  self
     */
    public function setOption(string $key, $value): self {
        if (\array_key_exists($key, $this->options)) {
            $this->options[$key] = $value;
        }

        return $this;
    }

    /**
     *
     * @return bool
     */
    public function isFileExtensionExists($ext): bool {
        return \in_array($ext, $this->fileExts);
    }
    /**
     *
     * @return array
     */
    public function getFileExtension(): array{
        return $this->fileExts;
    }

    /**
     *
     * @return self
     */
    public function addFileExtension(mixed $ext): self{
        $this->fileExts = \array_merge($this->fileExts, (\is_array($ext) ? $ext : [$ext]));

        return $this;
    }

    /**
     *
     * @return self
     */
    public function setFileExtension(array $exts): self{
        $this->fileExts = $exts;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param [type] $tag
     * @return bool
     */
    public function isExclusiveTag($tag): bool {
        return \in_array($tag, $this->exclusiveTags);
    }
    /**
     * Get the value of exclusiveTags
     *
     * @return array
     */
    public function getExclusiveTags(): array{
        return $this->exclusiveTags;
    }

    /**
     * Undocumented function
     *
     * @param array $exclusiveTags
     * @return self
     */
    public function setExclusiveTags(array $exclusiveTags): self{
        $this->exclusiveTags = $exclusiveTags;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param string $tag
     * @return self
     */
    public function addExclusiveTag(string $tag): self{
        $this->exclusiveTags[] = $tag;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param [type] $tag
     * @return self
     */
    public function removeExclusiveTag($tag): self {
        if (($key = \array_search($tag, $this->exclusiveTags)) !== FALSE) {
            unset($this->exclusiveTags[$key]);
        }

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return string
     */
    public function getOutputPrefix(): string {
        return $this->outputPrefix;
    }

    /**
     * Undocumented function
     *
     * @param string $outputPrefix
     * @return self
     */
    public function setOutputPrefix(string $outputPrefix): self{
        $this->outputPrefix = $outputPrefix;

        return $this;
    }
    /**
     * Undocumented function
     *
     * @return string
     */
    public function getOutputSuffix(): string {
        return $this->outputSuffix;
    }

    /**
     * Undocumented function
     *
     * @param string $ouputSuffix
     * @return self
     */
    public function setOutputSuffix(string $outputSuffix): self{
        $this->outputSuffix = $outputSuffix;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param boolean $enable
     * @return void
     */
    public function enableCache(bool $enable) {
        $this->options['CACHE_ENABLED'] = $enable;
        $this->options['GENERATE_EXPIRE_OUT_DATE'] |= $enable;
    }
    
    /**
     * Undocumented function
     *
     * @param string $var
     * @return string
     */
    public function cast(string $var): string {
        if (!$this->isVarToCast($var)) {
            return $var;
        }
        // /(([\'\"]?\w+[\'\"]?\.?)+)/ OLD
        // /((([\"\'].*?[\"\'])|(\w+)\.?)+)/ NEW !!
        $var = \preg_replace_callback('/((([\"\'].*?[\"\'])|(\w+)\.?)+)/',function($matches){
            return $this->castVar($matches[1]);
        },$var);
        return $var;
    }

    /**
     * Undocumented function
     *
     * @param string $var
     * @return boolean
     */
    public function isVarToCast(string $var): bool {
        return (
            !$this->options['VAR_STYLE_PHP'] &&
            !\is_numeric($var) &&
            \substr($var, 0, 1) != "'" &&
            \substr($var, 0, 1) != '"' &&
            \substr($var, 0, 1) != '$' &&
            \strtolower($var) != 'true' &&
            \strtolower($var) != 'false' &&
            !empty($var)
        );
    }
    /**
     * Undocumented function
     *
     * @param string $var
     * @return string
     */
    public function castVar(string $var): string {
        return ($this->isVarToCast($var) ? \str_replace('.', '->', "$$var") : $var);
    }
    /**
     * Undocumented function
     *
     * @param string $var
     * @return string
     */
    public function outVar(string $var): string {
        return (empty($var) ? "" : "<?php echo " . $this->cast($var) . " ;?>");
    }

    public function outExp(string $exp): string {
        return (empty($exp) ? "" : "<?php " . $this->cast($exp) . " ;?>");
    }

    /****************************************************************** */
    public function generateOutputFilename(string $template): string{
        $out_date = $this->options['GENERATE_OUT_DATE'] === true ? time() . $this->options['OUTPUT_SEPARATOR'] : "";
        $expire_date = $this->options['GENERATE_EXPIRE_OUT_DATE'] === true ? (time() + $this->expiresOutputFilename) . $this->options['OUTPUT_SEPARATOR'] : "";
        return (
            $out_date . $expire_date .
            (($this->outputPrefix != null) ? $this->outputPrefix . $this->options['OUTPUT_SEPARATOR'] : "") .
            str_replace(['/', '\\'], $this->options['DIR_SEPARATOR'], $template) .
            (($this->outputSuffix != null) ? $this->options['OUTPUT_SEPARATOR'] . $this->outputSuffix : "") .
            '.php');
    }

    public function retrieveOutputFilename(string $filename): string{
        $idx = 0;
        if ($this->options['GENERATE_OUT_DATE']) {
            $idx++;
        }

        if ($this->options['GENERATE_EXPIRE_OUT_DATE']) {
            $idx++;
        }

        if ($this->outputPrefix !== null) {
            $idx++;
        }

        $pattern = \explode($this->options['OUTPUT_SEPARATOR'], $filename);
        $template = \str_replace($this->options['DIR_SEPARATOR'], '/', $pattern[$idx]);
        return $template;
    }
    public function explodeOutputFilename(string $filename): array{
        $pattern = [];
        $exploded = \explode($this->options['OUTPUT_SEPARATOR'], $filename);
        $idx = 0;
        if ($this->options['GENERATE_OUT_DATE']) {
            $pattern['date'] = \intval($exploded[0]);
            $idx++;
        }
        if ($this->options['GENERATE_EXPIRE_OUT_DATE']) {
            $pattern['expires'] = \intval($exploded[$idx]);
            $idx++;
        }
        if ($this->outputPrefix !== null) {
            $pattern['prefix'] = $exploded[$idx];
            $idx++;
        }
        $pattern['template'] = \str_replace($this->options['DIR_SEPARATOR'], '/', $exploded[$idx]);
        $idx++;
        if ($this->outputSuffix !== null) {
            $pattern['suffix'] = $exploded[$idx];
        }
        return $pattern;
    }
    public function searchFromOutputFilename(string $template): string{
        $list = \scandir($this->getOutputFullPath());
        foreach ($list as $filename) {
            if (($out = $this->retrieveOutputFilename($filename)) == $template) {
                return $filename;
            }
        }
        return '';
    }

}