<?php

declare(strict_types=1);

namespace Unit\Commands;

use App\Commands\DownloadCommand;
use App\DotEnvWrapper;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

class DownloadCommandTest extends TestCase
{
    public function testExecute()
    {
        $dotEnv= new DotEnvWrapper();
        $dotEnv->init();
        $jokesDstFile = $dotEnv->projectDir . DIRECTORY_SEPARATOR . 'tests' . DIRECTORY_SEPARATOR . 'jokesTest.json';

        $commandTester = new CommandTester(new DownloadCommand($_ENV));
        $commandTester->execute([
            '-c' => 6,
            '-f' => $jokesDstFile,
            '-s' => $_ENV['CHUCKNORRIS_API_ALIAS'],
        ]);

        $commandTester->assertCommandIsSuccessful();
    }
}
