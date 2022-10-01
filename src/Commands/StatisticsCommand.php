<?php

declare(strict_types=1);

namespace App\Commands;

use App\File\FileReader;
use App\Mark;
use App\Statistics;
use Exception;
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
        $errors[] = $validator->checkFileName($marksSrcFile);
        $errors[] = $validator->checkFileExist($marksSrcFile);
        $errorFlag = false;
        foreach ($errors as $error)
            if ($error) {
                $output->writeln("<error>$error</>");
                $errorFlag = true;
            }

        if ($errorFlag) return Command::INVALID;

        try {
            $marks = (new FileReader())->read($marksSrcFile);
        } catch (Exception $e) {
            $output->writeln('<error>' . $e->getMessage() . '</>');
            return Command::FAILURE;
        }

        $stats = new Statistics();

        $io = new SymfonyStyle($input, $output);
        $io->title('Statistics.');
        $io->section('getMostPopularJokeIds');
        print_r($stats->getMostPopularJokeIds($marks));

        $io->section('getAvgMarkPerJoke');
        print_r($stats->getAvgMarkPerJoke($marks));

        $io->section('getTopRatedJokeIds');
        print_r($stats->getTopRatedJokeIds($marks));

        $io->section('getLowRatedJokeIds');
        print_r($stats->getLowRatedJokeIds($marks));

        $io->section('getJokeIdsLowerThen 3');
        print_r($stats->getJokeIdsLowerThen($marks, 3));

        $io->section('getTopRatedJokeIdPerMonth');
        foreach ($stats->getTopRatedJokeIdsPerMonth($marks) as $month => $id) {
            $output->writeln((string)$month);
            $output->writeln($id);
        }

        return Command::SUCCESS;
    }
}
