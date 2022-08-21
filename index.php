<?php

require 'vendor/autoload.php';

use App\App;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
$dotenv->required(['apiKey'])->notEmpty();
$dotenv->required(['jokesFile'])->notEmpty();
$dotenv->required(['personsFile'])->notEmpty();
$dotenv->required(['marksFile'])->notEmpty();

App::run($_ENV['jokesFile'], $_ENV['personsFile'], $_ENV['marksFile']);
