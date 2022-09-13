<?php

namespace Unit\Commands;

use App\Commands\ShowCommand;
use App\DotEnvWrapper;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

class ShowCommandTest extends TestCase
{
    public function testExecute()
    {
        (new DotEnvWrapper())->init();

        $commandTester = new CommandTester(new ShowCommand($_ENV));
        $commandTester->execute([
            '--source' => $_ENV['CHUCKNORRIS_API_ALIAS'],
        ]);

        $commandTester->assertCommandIsSuccessful();

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Joke from chucknorris:', $output);
    }
}
