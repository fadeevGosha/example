<?php


namespace App\Services;


interface IMarkdownParser
{
    public function parse(string $text): string;
}