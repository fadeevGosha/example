<?php


namespace App\Services;


use Demontpx\ParsedownBundle\Parsedown;
use Psr\Log\LoggerInterface;

class MarkdownParser implements IMarkdownParser
{
    /**
     * @var Parsedown
     */
    private Parsedown $parseDown;
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    public function __construct(Parsedown $parseDown, LoggerInterface $logger)
    {
        $this->parseDown = $parseDown;
        $this->logger = $logger;
    }

    public function parse(string $text): string
    {
        return $this->parseDown->parse($text);
    }
}