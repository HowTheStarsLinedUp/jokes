<?php

namespace Unit\Commands;

use App\Commands\StatisticsCommand;
use App\DotEnvWrapper;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

class StatisticsCommandTest extends TestCase
{
    public function testExecute()
    {
        $dotEnv= new DotEnvWrapper();
        $dotEnv->init();
        $marksSrcFile = $dotEnv->projectDir . DIRECTORY_SEPARATOR . 'tests' . DIRECTORY_SEPARATOR . 'marksExample.json';

        $commandTester = new CommandTester(new StatisticsCommand());
        $commandTester->execute([
            'marksSrcFile' => $marksSrcFile,
        ]);

        $commandTester->assertCommandIsSuccessful();
    }
}
