<?php

declare(strict_types=1);

namespace Unit\Commands;

use App\Commands\GenerateCommand;
use App\DotEnvWrapper;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

class GenerateCommandTest extends TestCase
{
    public function testGenerateFromCsvToCsv()
    {
        $dotEnv= new DotEnvWrapper();
        $dotEnv->init();
        $marksDstFile = $dotEnv->projectDir . DIRECTORY_SEPARATOR . 'tests' . DIRECTORY_SEPARATOR . 'marksTest.csv';
        $jokesSrcFile = $dotEnv->projectDir . DIRECTORY_SEPARATOR . 'tests' . DIRECTORY_SEPARATOR . 'jokesExample.csv';

        $commandTester = new CommandTester(new GenerateCommand($_ENV));
        $commandTester->execute([
            'personCount' => 10,
            'maxMarksPerJoke' => 10,
            'fromDate' => '2022-01',
            'toDate' => '2022-12',
            'jokesSrcFile' => $jokesSrcFile,

            '--file' => $marksDstFile,
            '--maxMark' => 15,
        ]);

        $commandTester->assertCommandIsSuccessful();
    }

    public function testGenerateFromJsonToJson()
    {
        $dotEnv= new DotEnvWrapper();
        $dotEnv->init();
        $marksDstFile = $dotEnv->projectDir . DIRECTORY_SEPARATOR . 'tests' . DIRECTORY_SEPARATOR . 'marksTest.json';
        $jokesSrcFile = $dotEnv->projectDir . DIRECTORY_SEPARATOR . 'tests' . DIRECTORY_SEPARATOR . 'jokesExample.json';

        $commandTester = new CommandTester(new GenerateCommand($_ENV));
        $commandTester->execute([
            'personCount' => 10,
            'maxMarksPerJoke' => 10,
            'fromDate' => '2022-01',
            'toDate' => '2022-12',
            'jokesSrcFile' => $jokesSrcFile,

            '--file' => $marksDstFile,
            '--maxMark' => 15,
        ]);

        $commandTester->assertCommandIsSuccessful();
    }
}
