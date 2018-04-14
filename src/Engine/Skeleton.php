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
use Graal\Bone\Engine\Skeleton\SkeletonException;
use Graal\Bone\Engine\SKeleton\SkeletonInterface;

class Skeleton implements SkeletonInterface {

    protected $basePath;
    protected $templateDir;
    protected $outputDir;
    protected $outputPrefix;
    protected $ouputSuffix;
    protected $templateFullPath;
    protected $outputFullPath;
    protected $options = [
        'DIR_SEPARATOR'             => '$',
        'GENERATE_OUT_DATE'         => false,
        'GENERATE_EXPIRE_OUT_DATE'  => false
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

    }

    /**
     *
     * @return string
     */
    public function compile(string $template): string {
        # compile the template

        # put in output file
    }

    /**
     * Undocumented function
     *
     * @return self
     */
    public function start(): self {
        \ob_start();
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function end() {
        \ob_end_flush();
    }
    /**
     *
     */
    public function render(string $template, array $params = []): string {
        if (!$this->templateExists($template)) {
            throw new SkeletonException("The template \"$template\" file does not exist", 1);
        }

        /* TODO LIST */
        # check for cached template     |

        # compile the template          |
        # put in output file            | > function compile()
        $this->compile(Html5::createFromFile($template)->getContent());

        # start render                  | > function start()

        # extract params                |
        # extract globals params        | > function extractCommon();
        # extract functions             |

        # include output file           |
        # get content of output file    |> function getCompiledTemplateContent();

        # end render                    |> function end()

        # return $content ;

    }

    /**
     *
     */
    public function templateExists(string $template): boolean {
        foreach ($this->fileExts as $ext) {
            if (file_exists($this->getTemplateFullPath($template . $ext))) {
                return true;
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
     * @return boolean
     */
    public function isFileExtensionExists($ext): boolean {
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
     * @return boolean
     */
    public function isExclusiveTag($tag): boolean {
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
    public function getOuputSuffix(): string {
        return $this->ouputSuffix;
    }

    /**
     * Undocumented function
     *
     * @param string $ouputSuffix
     * @return self
     */
    public function setOuputSuffix(string $ouputSuffix): self{
        $this->ouputSuffix = $ouputSuffix;

        return $this;
    }
    /****************************************************************** */
    public function generateOutputFilename(string $template): string {
        return (
            (($this->outputPrefix != null) ? $this->outputPrefix . '.' : "") .
            str_replace(['/', '\\'], $this->options['DIR_SEPARATOR'], $template) .
            (($this->ouputSuffix != null) ? '.' . $this->ouputSuffix : "") .
            '.php');
    }

}