<?php


namespace App\Services;


interface IArticleContentProvider
{
    public function get(int $countParagraphs, string $word = null, int $wordsCount = 0, bool $isNeedParse = true): string;

    public function addWordToText(string $text, string $word): string;

    public function setMarkArticleWordsWithBold(bool $markArticleWordsWithBold): void;
}