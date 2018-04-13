<?php declare(strict_types=1);
namespace Graal\Bone\Engine;
interface TemplateEngineInterface {
    function render(string $template,array $params);
}