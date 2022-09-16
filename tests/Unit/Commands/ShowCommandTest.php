<?php

namespace Unit\Commands;

use App\Commands\ShowCommand;
use App\DotEnvWrapper;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

class ShowCommandTest extends TestCase
{
    public function testPositiveExecute()
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

    public function testWrongSource()
    {
        (new DotEnvWrapper())->init();

        $commandTester = new CommandTester(new ShowCommand($_ENV));
        $commandTester->execute([
            '--source' => 'wrongSource',
        ]);
        $this->assertEquals(2, $commandTester->getStatusCode());

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString("Command invalid. Source must be 'chucknorris' or 'dadjokes'.", $output);
    }
}
