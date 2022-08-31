<?php

declare(strict_types=1);

namespace App\Commands;

use App\ChuckApiClient;
use App\DadJokesApiClient;
use GuzzleHttp\Client;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ShowCommand extends Command
{
    protected function configure() : void
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

    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        $source = $input->getOption('source');
        $guzzleClient = new Client(['timeout' => $_ENV['GUZZLE_CLIENT_TIMEOUT']]);

        if ($source == $_ENV['CHUCKNORRIS_API_ALIAS']) {
            $jokeDownloader = new ChuckApiClient($guzzleClient);
        } elseif ($source == $_ENV['DADJOKES_API_ALIAS']) {
            $jokeDownloader = new DadJokesApiClient($guzzleClient);
        } else {
            if (empty($source)) {
                $output->writeln('<error>Empty source.</>');
            } else {
                $output->writeln('<error>Source is not valid.</>');
            }
            return Command::INVALID;
        }

        $joke = $jokeDownloader->downloadJokes(1);

        $output->writeln([
            "<info>Joke from $source:</>",
            '<info>' . $joke[0]->getText() . '</>',
            '',
        ]);

        return Command::SUCCESS;
    }
}
