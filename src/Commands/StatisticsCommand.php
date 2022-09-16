<?php

declare(strict_types=1);

namespace App\Commands;

use App\Statistics;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 *  example: php ./index.php statistics
 */
class StatisticsCommand extends Command
{
    protected function configure(): void
    {
        $this->setName('statistics')
            ->setDescription('Shows statistics.')
            ->addArgument('marksSrcFile', InputArgument::REQUIRED, 'Path to marks storage file.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $marksSrcFile = $input->getArgument('marksSrcFile');

        $validator = new CommandValidator();
        $errors[] = $validator->checkSrcFile($marksSrcFile);
        $errorFlag = false;
        foreach ($errors as $error)
            if ($error) {
                $output->writeln("<error>$error</>");
                $errorFlag = true;
            }

        if ($errorFlag) return Command::INVALID;


        $marks = json_decode(file_get_contents($marksSrcFile), true, flags: JSON_THROW_ON_ERROR);
        $stats = new Statistics();

//        $io = new SymfonyStyle($input, $output);
//        $io->title('Statistics.');
//        $io->section('getMostPopularJokeId');
//        print_r($stats->getMostPopularJokeId());
//
//        $io->section('getAvgMarkPerJoke');
//        print_r($stats->getAvgMarkPerJoke());
//
//        $io->section('getTopRatedJokeId');
//        print_r($stats->getTopRatedJokeIds());
//
//        $io->section('getLowRatedJokeId');
//        print_r($stats->getLowRatedJokeIds());
//
//        $io->section('getJokeIdsLowerThen 3');
//        print_r($stats->getJokeIdsLowerThen(3));

//        $io->section('getTopRatedJokeIdPerMonth');

        foreach ($stats->getTopRatedJokeIdsPerMonth($marks) as $month => $id) {
            $output->writeln((string)$month);
            $output->writeln($id);
        }

        return Command::SUCCESS;
    }
}
