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
    protected $templateFullPath;
    protected $outputFullPath;
    protected $options = [];
    protected $fileExts = [
        '.html',
        '.bone',
        '.bone.html',
        '.html.bone',
        '.css'
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

    }

    /**
     *
     */
    public function render(string $template, array $params = []) {
        if (!$this->templateExists()) {
            throw new SkeletonException("The template \"$template\" file does not exist", 1);

        }
    }

    /**
     *
     */
    public function templateExists(string $template): boolean {
        return \file_exists($this->getTemplateFullPath($template));
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
    public function getOutputFullPath(): string {
        if ($this->outputFullPath == null) {
            $this->outputFullPath =
                (($this->basePath != null) ? rtrim($this->basePath, '\/') . '/' : "") .
                (($this->outputDir != null) ? rtrim($this->outputDir, '\/') . '/' : "");
        }
        return $this->outputFullPath;
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
        return \in_array($ext,$this->fileExts);
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
}