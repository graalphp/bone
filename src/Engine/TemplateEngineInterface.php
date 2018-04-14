<?php declare(strict_types=1);
namespace Graal\Bone\Engine;
interface TemplateEngineInterface {
    function compile(string $template);
    function render(string $template,array $params);
}