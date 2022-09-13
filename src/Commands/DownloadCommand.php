<?php

declare(strict_types=1);

namespace App\Commands;

use App\ApiAlias;
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
    private array $cfg;

    public function __construct(array $cfg, string $name = null)
    {
        $this->cfg = $cfg;
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->setName('download')
            ->setDescription('Downloads jokes and saves them to a file.')
            ->addOption(
                'count',
                'c',
                InputOption::VALUE_OPTIONAL,
                'Number of jokes.',
                1
            )->addOption(
                'file',
                'f',
                InputOption::VALUE_OPTIONAL,
                'File path to store jokes. You can use json or csv.',
                $this->cfg['JOKES_FILE']
            )->addOption(
                'source',
                's',
                InputOption::VALUE_OPTIONAL,
                'The joke source alias. Where it comes from.',
                $this->cfg['CHUCKNORRIS_API_ALIAS']
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $count = intval($input->getOption('count'));
        $fileName = $input->getOption('file');
        $sourceAlias = ApiAlias::from($input->getOption('source'));

        $valid = new CommandValidator($output);
        if (!$valid->count($count)
            or !$valid->fileName($fileName)
        ) return Command::INVALID;

        $guzzleClient = new Client(['timeout' => $this->cfg['GUZZLE_CLIENT_TIMEOUT']]);
        $jokeProvider = new JokeProvider($guzzleClient);
        $jokes = $jokeProvider->getJokes($count, $sourceAlias);
        (new FileWriter)->write($jokes, $fileName);

        return Command::SUCCESS;
    }
}
