<?php

declare(strict_types=1);

namespace App\Commands;

use App\ApiAlias;
use App\JokeProvider;
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
    public function __construct(array $cfg, string $name = null)
    {
        $this->cfg = $cfg;
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->setName('show')
            ->setDescription('Downloads joke and print it to console.')
            ->addOption(
                'source',
                's',
                InputOption::VALUE_OPTIONAL,
                'The joke source alias. Where it comes from.',
                $this->cfg['CHUCKNORRIS_API_ALIAS']
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $sourceAlias = ApiAlias::from($input->getOption('source'));
        $guzzleClient = new Client(['timeout' => $_ENV['GUZZLE_CLIENT_TIMEOUT']]);
        $joke = (new JokeProvider($guzzleClient))->getJokes(1, $sourceAlias);

        $output->writeln([
            "<info>Joke from $sourceAlias->value:</>",
            '<info>' . $joke[0]->getText() . '</>',
            '',
        ]);

        return Command::SUCCESS;
    }
}
