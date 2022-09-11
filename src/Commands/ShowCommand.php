<?php

declare(strict_types=1);

namespace App\Commands;

use App\ApiAlias;
use App\ChuckApiClient;
use App\DadJokesApiClient;
use GuzzleHttp\Client;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 *  example: php ./index.php show -s chucknorris
 */
class ShowCommand extends Command
{
    protected function configure(): void
    {
        $this->setName('show')
            ->setDescription('Downloads joke and print it to console.')
            ->addOption(
                'source',
                's',
                InputOption::VALUE_OPTIONAL,
                'The joke source alias. Where it comes from.',
                $_ENV['CHUCKNORRIS_API_ALIAS']
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $sourceAlias = ApiAlias::from($input->getOption('source'));
        $guzzleClient = new Client(['timeout' => $_ENV['GUZZLE_CLIENT_TIMEOUT']]);

        switch ($sourceAlias->value) {
            case $_ENV['CHUCKNORRIS_API_ALIAS']:
                $jokeDownloader = new ChuckApiClient($guzzleClient);
                break;
            case $_ENV['DADJOKES_API_ALIAS']:
                $jokeDownloader = new DadJokesApiClient($guzzleClient);
                break;
            default:
                $output->writeln('<error>Source is not valid.</>');
                return Command::INVALID;
        }

        $joke = $jokeDownloader->downloadJokes(1);

        $output->writeln([
            "<info>Joke from $sourceAlias:</>",
            '<info>' . $joke[0]->getText() . '</>',
            '',
        ]);

        return Command::SUCCESS;
    }
}
