<?php

declare(strict_types=1);

namespace Unit\Commands;

use App\Commands\DownloadCommand;
use App\DotEnvWrapper;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

class DownloadCommandTest extends TestCase
{
    private string $jokesDstFile;

    public function setUp(): void
    {
        $dotEnv= new DotEnvWrapper();
        $dotEnv->init();
        $this->jokesDstFile = $dotEnv->projectDir . DIRECTORY_SEPARATOR . 'tests' . DIRECTORY_SEPARATOR . 'jokesTest.json';
    }

    public function testPositiveExecute()
    {
        $commandTester = new CommandTester(new DownloadCommand($_ENV));
        $commandTester->execute([
            '-c' => 6,
            '-f' => $this->jokesDstFile,
            '-s' => $_ENV['CHUCKNORRIS_API_ALIAS'],
        ]);

        $commandTester->assertCommandIsSuccessful();
    }

    public function testWrongFileExtension()
    {
        $commandTester = new CommandTester(new DownloadCommand($_ENV));
        $commandTester->execute([
            '-c' => 6,
            '-f' => 'WrongFileExt.jayson',
            '--source' => $_ENV['CHUCKNORRIS_API_ALIAS'],
        ]);
        $this->assertEquals(2, $commandTester->getStatusCode());

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString("Command invalid. File extension must be 'json' or 'csv'.", $output);
    }

    public function testWrongSource()
    {
        $commandTester = new CommandTester(new DownloadCommand($_ENV));
        $commandTester->execute([
            '-c' => 6,
            '-f' => $this->jokesDstFile,
            '--source' => 'wrongSource',
        ]);
        $this->assertEquals(2, $commandTester->getStatusCode());

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString("Command invalid. Source must be 'chucknorris' or 'dadjokes'.", $output);
    }
}
