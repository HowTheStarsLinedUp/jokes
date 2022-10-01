<?php

declare(strict_types=1);

namespace App\Commands;

use App\File\FileWriter;
use App\JokeProvider;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
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
        $count = (int)$input->getOption('count');
        $fileName = $input->getOption('file');
        $sourceAlias = $input->getOption('source');

        $validator = new CommandValidator();
        $errors[] = $validator->checkCount($count);
        $errors[] = $validator->checkFileName($fileName);
        $errors[] = $validator->checkFileExist($fileName);
        $errors[] = $validator->checkSource($sourceAlias, $this->cfg);
        $errorFlag = false;
        foreach ($errors as $error)
            if ($error) {
                $output->writeln("<error>$error</>");
                $errorFlag = true;
            }

        if ($errorFlag) return Command::INVALID;

        $guzzleClient = new Client(['timeout' => $this->cfg['GUZZLE_CLIENT_TIMEOUT']]);

        try {
            $jokes = (new JokeProvider($guzzleClient))->getJokes($count, $sourceAlias, $this->cfg);
            (new FileWriter)->write($jokes, $fileName);
        } catch (Exception|GuzzleException $e) {
            $output->writeln('<error>' . $e->getMessage() . '</>');
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
