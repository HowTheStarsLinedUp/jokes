<?php

declare(strict_types=1);

namespace Unit;

use App\File\MarkReader;
use App\Mark;
use PHPUnit\Framework\TestCase;

class MarkReaderTest extends TestCase
{
    private array $actualMarksArray;
    private int $expectedMarksCount = 25;
    private string $fileName = '../marksExample.json';
    private MarkReader $reader;

    public function testGettingAvgMarkPerJoke(): void
    {
        $this->givenMarkReader();
        $this->whenReading();
        $this->thenCheckMarks();
    }

    private function givenMarkReader(): void
    {
        $this->reader = new MarkReader();
    }

    private function whenReading(): void
    {
        $this->actualMarksArray = $this->reader->read($this->fileName);
    }

    private function thenCheckMarks(): void
    {
        $this->assertEquals($this->expectedMarksCount, count($this->actualMarksArray));
        $this->assertContainsOnlyInstancesOf(Mark::class, $this->actualMarksArray);
    }
}
