<?php

namespace App\Command;

use App\Services\IArticleContentProvider;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ArticleContentProviderCommand extends Command
{
    protected static $defaultName = 'app:article:content_provider';
    protected static $defaultDescription = 'Article content generator';
    /**
     * @var IArticleContentProvider
     */
    private IArticleContentProvider $articleContentProvider;

    public function __construct(IArticleContentProvider $articleContentProvider)
    {
        $this->articleContentProvider = $articleContentProvider;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addArgument('countParagraphs', InputArgument::REQUIRED, 'Number of paragraphs')
            ->addArgument('word', InputArgument::OPTIONAL, 'The inserted word')
            ->addArgument('wordsCount', InputArgument::OPTIONAL, 'Number of inserted words')
            ->addOption(
                'markArticleWordsWithBold',
                null,
                InputOption::VALUE_OPTIONAL,
                'Нужно ли выделить жирным',
                false
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $countParagraphs = $input->getArgument('countParagraphs');

        $word = $input->getArgument('word') ?? null;
        $wordsCount = $input->getArgument('wordsCount') ?? 0;

        $markArticleWordsWithBold = $input->getOption('markArticleWordsWithBold');
        $this->articleContentProvider->setMarkArticleWordsWithBold($markArticleWordsWithBold);

        $text = $this->articleContentProvider->get($countParagraphs, $word, $wordsCount);
        $io->success(sprintf('Your text: %s', $text));

        return Command::SUCCESS;
    }
}
