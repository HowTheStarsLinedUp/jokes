<?php

declare(strict_types=1);

namespace App\Commands;

use App\File\FileWriter;
use App\JokeProvider;
use GuzzleHttp\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 *  php ./index.php download -c 1 -s chucknorris -f ./tmp/test/folder/file.csv
 */
class DownloadCommand extends Command
{
    protected function configure() : void
    {
        $this->setName('download')
            ->setDescription('Downloads jokes and saves them to a file.')
            ->addOption(
                'count',
                'c',
                InputOption::VALUE_OPTIONAL,
                'Number of jokes.',
            )->addOption(
                'source',
                's',
                InputOption::VALUE_OPTIONAL,
                'The joke source alias. Where it comes from.',
                $_ENV['CHUCKNORRIS_API_ALIAS']
            )->addOption(
                'filename',
                'f',
                InputOption::VALUE_OPTIONAL,
                'File path. You can use json or csv.',
                $_ENV['JOKES_FILE']
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        $sourceAlias = $input->getOption('source');
        $count = intval($input->getOption('count'));
        $fileName = $input->getOption('filename');

        $valid = new CommandValidator($output);
        if(!$valid->source($sourceAlias)
            or !$valid->count($count)
            or !$valid->fileName($fileName)
        ) return Command::INVALID;

        $guzzleClient = new Client(['timeout' => $_ENV['GUZZLE_CLIENT_TIMEOUT']]);
        $jokeProvider = new JokeProvider($guzzleClient);
        $jokes = $jokeProvider->getJokes($count, $sourceAlias);
        (new FileWriter)->write($jokes, $fileName);

        return Command::SUCCESS;
    }
}
