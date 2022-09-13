<?php

declare(strict_types=1);

namespace App\Commands;

use App\File\FileWriter;
use App\Mark;
use App\Person;
use JsonMachine\Items;
use JsonMachine\JsonDecoder\ExtJsonDecoder;
use Symfony\Component\Console\{
    Command\Command,
    Input\InputArgument,
    Input\InputInterface,
    Input\InputOption,
    Output\OutputInterface
};

/**
 *  example: php ./index.php generate 100 10 '2022-01' '2022-12' ./jokes.json
 */
class GenerateCommand extends Command
{
    private array $cfg;

    public function __construct(array $cfg, string $name = null)
    {
        $this->cfg = $cfg;
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->setName('generate')
            ->setDescription('Generates Persons and Marks.')
            ->addArgument('personCount', InputArgument::REQUIRED, 'How many persons to generate.')
            ->addArgument('maxMarksPerJoke', InputArgument::REQUIRED, 'Maximum random marks per joke.')
            ->addArgument('fromDate', InputArgument::REQUIRED, "Date to generate marks from. Format '2022-01'.")
            ->addArgument('toDate', InputArgument::REQUIRED, "Date to generate marks to. Format '2022-12'.")
            ->addArgument('jokesSrcFile', InputArgument::REQUIRED, 'Path to jokes storage file.')
            ->addOption(
                'file',
                'f',
                InputOption::VALUE_OPTIONAL,
                'File path for saved marks.',
                $this->cfg['MARKS_FILE']
            )->addOption(
                'maxMark',
                'm',
                InputOption::VALUE_OPTIONAL,
                'Maximum mark value.',
                10
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $personCount = intval($input->getArgument('personCount'));
        $maxMarksPerJoke = intval($input->getArgument('maxMarksPerJoke'));
        $jokesSrcFile = $input->getArgument('jokesSrcFile');
        $fromDate = $input->getArgument('fromDate');
        $toDate = $input->getArgument('toDate');
        $maxMarkValue = $input->getOption('maxMark');
        $marksDestFile = $input->getOption('file');
        $valid = new CommandValidator($output);

        if (!$valid->date($fromDate) or !$valid->date($toDate)) return Command::INVALID;
        $fromTimestamp = strtotime($fromDate);
        $toTimestamp = strtotime(date('Y-m-t', strtotime($toDate)));

        $persons = [];
        for ($i = 0; $i < $personCount; $i++) {
            $persons[] = new Person(uniqid());
        }

        $jokes = Items::fromFile($jokesSrcFile, ['decoder' => new ExtJsonDecoder(true)]);
        $personsCount = count($persons);
        $marks = [];

        foreach ($jokes as $joke) {
            $marksCount = random_int(0, $maxMarksPerJoke);
            for ($i = 0; $i < $marksCount; $i++) {
                $marks[] = new Mark(
                    $joke['sourceId'],
                    $persons[random_int(0, $personsCount - 1)]->getId(),
                    random_int(1, $maxMarkValue),
                    random_int($fromTimestamp, $toTimestamp),
                );
            }
        }

        (new FileWriter())->write($marks, $marksDestFile);

        return Command::SUCCESS;
    }
}
