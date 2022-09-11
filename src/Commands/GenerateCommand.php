<?php

declare(strict_types=1);

namespace App\Commands;

use App\File\FileWriter;
use App\Mark;
use App\Person;
use JsonMachine\Items;
use JsonMachine\JsonDecoder\ExtJsonDecoder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 *  example: php ./index.php generate 100 10 ./jokes.json '2022-01' '2022-12'
 */
class GenerateCommand extends Command
{
    protected function configure() : void
    {
        $this->setName('generate')
            ->setDescription('Generates Persons and Marks.')
            ->addArgument('personCount', InputArgument::REQUIRED, 'How many persons to generate.')
            ->addArgument('maxMarksPerJoke', InputArgument::REQUIRED, 'Maximum random marks per joke.')
            ->addArgument('jokesSrcFile', InputArgument::REQUIRED, 'Path to jokes storage file.')
            ->addArgument('from', InputArgument::REQUIRED, 'Date to generate marks from.')
            ->addArgument('to', InputArgument::REQUIRED, 'Date to generate marks to.')
            ->addOption(
                'file',
                'f',
                InputOption::VALUE_OPTIONAL,
                'File path for saved marks.',
                $_ENV['MARKS_FILE']
            )->addOption(
                'maxMark',
                null,
                InputOption::VALUE_OPTIONAL,
                'Maximum mark value.',
                10
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        $personCount = intval($input->getArgument('personCount'));
        $maxMarksPerJoke = intval($input->getArgument('maxMarksPerJoke'));
        $jokesSrcFile = $input->getArgument('jokesSrcFile');
        $from = $input->getArgument('from');
        $to = $input->getArgument('to');
        $maxMarkValue = $input->getOption('maxMark');
        $marksDestFile = $input->getOption('file');
        $valid = new CommandValidator($output);

        if (!$valid->date($from) or !$valid->date($to)) return Command::INVALID;
        $fromTimestamp = strtotime($from);
        $toTimestamp = strtotime(date('Y-m-t', strtotime($to)));

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
                    $persons[random_int(0, $personsCount-1)]->getId(),
                    random_int(1, $maxMarkValue),
                    random_int($fromTimestamp, $toTimestamp),
                );
            }
        }

        (new FileWriter())->write($marks, $marksDestFile);

        return Command::SUCCESS;
    }
}
