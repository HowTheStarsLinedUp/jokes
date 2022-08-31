<?php

declare(strict_types=1);

namespace App\Commands;

use App\Statistics;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class StatisticsCommand extends Command
{
    protected function configure() : void
    {
        $this->setName('statistics')
            ->setDescription('Shows statistics.')
            ->addArgument('marksSrcFile', InputArgument::OPTIONAL, 'Path to marks storage file.', $_ENV['MARKS_FILE']);
    }

    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        $marksSrcFile = $input->getArgument('marksSrcFile');
        $stats = new Statistics($marksSrcFile);

        $io = new SymfonyStyle($input, $output);
        $io->title('Statistics.');
        $io->section('getMostPopularJokeId');
        print_r($stats->getMostPopularJokeId());

        $io->section('getAvgMarkPerJoke');
        print_r($stats->getAvgMarkPerJoke());

        $io->section('getTopRatedJokeId');
        print_r($stats->getTopRatedJokeId());

        $io->section('getLowRatedJokeId');
        print_r($stats->getLowRatedJokeId());

        $io->section('getJokeIdsLowerThen 3');
        print_r($stats->getJokeIdsLowerThen(3));

        $io->section('getTopRatedJokeIdPerMonth');
        print_r($stats->getTopRatedJokeIdPerMonth());

        return Command::SUCCESS;
    }
}
