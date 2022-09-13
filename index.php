<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use App\DotEnvWrapper;
use App\Commands\{DownloadCommand, GenerateCommand, ShowCommand, StatisticsCommand};
use Symfony\Component\Console\Application;

(new DotEnvWrapper())->init();

$app = new Application();
$app->add(new DownloadCommand($_ENV));
$app->add(new ShowCommand($_ENV));
$app->add(new GenerateCommand($_ENV));
$app->add(new StatisticsCommand());
$app->run();
