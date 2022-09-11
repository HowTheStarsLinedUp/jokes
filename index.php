<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use App\Commands\{DownloadCommand, GenerateCommand, ShowCommand, StatisticsCommand};
use Dotenv\Dotenv;
use Symfony\Component\Console\Application;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
$dotenv->required(['RAPIDAPI_KEY'])->notEmpty();
$dotenv->required(['JOKES_FILE'])->notEmpty();
$dotenv->required(['PERSONS_FILE'])->notEmpty();
$dotenv->required(['MARKS_FILE'])->notEmpty();

$app = new Application();
$app->add(new DownloadCommand());
$app->add(new ShowCommand());
$app->add(new GenerateCommand());
$app->add(new StatisticsCommand());
$app->run();
