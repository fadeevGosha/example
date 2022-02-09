<?php

namespace App\Twig;

use App\Services\IMarkdownParser;
use Twig\Extension\RuntimeExtensionInterface;

class AppRuntime implements RuntimeExtensionInterface
{
    private IMarkdownParser $markdownParser;

    public function __construct(IMarkdownParser $markdownParser)
    {
        $this->markdownParser = $markdownParser;
    }

    public function parseMarkdown(string $content): string
    {
        return $this->markdownParser->parse($content);
    }
}