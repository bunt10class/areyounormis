<?php

declare(strict_types=1);

namespace Core\Template;

class TemplateRenderer
{
    private string $path;
    private ?string $extend;
    private array $data = [];

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function render(string $view, array $params = []): string
    {
        $this->setExtend(null);

        $template = $this->path . DIRECTORY_SEPARATOR . $view . '.php';

        ob_start();
        extract($params);
        require $template;
        $content = ob_get_clean();

        if (is_null($this->extend)) {
            return $content;
        }

        $this->addData('content', $content);
        return $this->render($this->extend);
    }

    public function setExtend(?string $extend): void
    {
        $this->extend = $extend;
    }

    public function addData(string $key, mixed $value): void
    {
        $this->data[$key] = $value;
    }
}