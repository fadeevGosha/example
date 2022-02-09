<?php


namespace App\Services;


class ArticleContentProvider implements IArticleContentProvider
{
    /**
     * @var IMarkdownParser
     */
    private IMarkdownParser $markdownParser;
    private bool $markArticleWordsWithBold;

    public function __construct(IMarkdownParser $markdownParser, bool $markArticleWordsWithBold)
    {
        $this->markdownParser = $markdownParser;
        $this->markArticleWordsWithBold = $markArticleWordsWithBold;
    }

    public function get(
        int $countParagraphs,
        string $word = null,
        int $wordsCount = 0,
        bool $isNeedParse = true
    ): string {
        $text = $this->getRandTextByCountParagraphs($countParagraphs);

        if ($word) {
            $word = $this->markArticleWordsWithBold ? "**$word**" : "*$word*";
            $text = $this->addWordToText($text, $word, $wordsCount);
        }

        return $isNeedParse ? mb_convert_encoding($this->markdownParser->parse($text), 'UTF-8', 'UTF-8') : $text;
    }

    public function getRandTextByCountParagraphs(int $countParagraphs): string
    {
        $templateParagraphs = ArticleService::PARAGRAPHS;
        $countTemplateParagraphs = count($templateParagraphs);

        if ($countParagraphs > $countTemplateParagraphs) {
            $count = $countParagraphs - $countTemplateParagraphs;
            while ($count > 0) {
                $key = array_rand($templateParagraphs);
                $templateParagraphs[] = $templateParagraphs[$key];
                $count--;
            }
        }

        $keys = array_rand($templateParagraphs, $countParagraphs);
        $text = [];

        if (is_array($keys)) {
            foreach ($keys as $key) {
                $text[] = '<br>' . $templateParagraphs[$key] . '</br>';
            }
        } else {
            $text[] = $templateParagraphs[$keys];
        }

        return implode("", $text);
    }

    public function addWordToText(string $text, string $word, int $wordsCount = 0): string
    {
        $wordsCount = $wordsCount === 0 ? 1 : $wordsCount;

        $array = explode(' ', $text);
        $keys = array_rand($array, $wordsCount);

        if (is_array($keys)) {
            foreach ($keys as $key) {
                $array[$key + 1] = $word;
            }
        } else {
            $array[$keys + 1] = $word;
        }

        return implode(' ', $array);
    }

    /**
     * @param bool $markArticleWordsWithBold
     * @required
     */
    public function setMarkArticleWordsWithBold(bool $markArticleWordsWithBold): void
    {
        $this->markArticleWordsWithBold = $markArticleWordsWithBold;
    }
}