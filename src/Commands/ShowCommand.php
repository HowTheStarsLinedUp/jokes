<?php

declare(strict_types=1);

namespace App\Commands;

use App\JokeProvider;
use GuzzleHttp\Client;
use Symfony\Component\Console\{Command\Command, Input\InputInterface, Input\InputOption, Output\OutputInterface};

/**
 *  example: php ./index.php show -s chucknorris
 */
class ShowCommand extends Command
{
    private array $cfg;

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
        $sourceAlias = $input->getOption('source');

        $validator = new CommandValidator();
        $errors[] = $validator->checkSource($sourceAlias, $this->cfg);
        $errorFlag = false;
        foreach ($errors as $error)
            if ($error) {
                $output->writeln("<error>$error</>");
                $errorFlag = true;
            }

        if ($errorFlag) return Command::INVALID;

        $guzzleClient = new Client(['timeout' => $this->cfg['GUZZLE_CLIENT_TIMEOUT']]);
        $joke = (new JokeProvider($guzzleClient))->getJokes(1, $sourceAlias, $this->cfg);

        $output->writeln([
            "<info>Joke from $sourceAlias:</>",
            '<info>' . $joke[0]->getText() . '</>',
            '',
        ]);

        return Command::SUCCESS;
    }
}
