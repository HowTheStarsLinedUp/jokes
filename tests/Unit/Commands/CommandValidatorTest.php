<?php

namespace Commands;

use App\Commands\CommandValidator;
use PHPUnit\Framework\TestCase;

class CommandValidatorTest extends TestCase
{
    private CommandValidator $validator;

    public function setUp(): void
    {
        $this->validator = new CommandValidator();
    }

    /**
     * @dataProvider checkCountDataProvider
     */
    public function testCheckCount(int $count, bool|string $expected)
    {
        $this->assertEquals($expected, $this->validator->checkCount($count));
    }

    public function checkCountDataProvider(): array
    {
        return [
            'Positive' => [200, false],
            'Lowest' => [0, "Command invalid. 'count' must be above 1 and lower then 251." . PHP_EOL],
            'Highest' => [251, "Command invalid. 'count' must be above 1 and lower then 251." . PHP_EOL],
        ];
    }

    /**
     * @dataProvider checkDateDataProvider
     */
    public function testCheckDate(string $date, bool|string $expected)
    {
        // format yyyy-mm: "2012-02"
        $this->assertEquals($expected, $this->validator->checkDate($date));
    }

    public function checkDateDataProvider(): array
    {
        return [
            0 => ['2000-12', false],
            1 => ['200-12', "Command invalid. Date format must be 'yyyy-mm' like '2022-08'." . PHP_EOL],
            2 => ['20010-12', "Command invalid. Date format must be 'yyyy-mm' like '2022-08'." . PHP_EOL],
            3 => ['2000-0', "Command invalid. Date format must be 'yyyy-mm' like '2022-08'." . PHP_EOL],
            4 => ['2000-13', "Command invalid. Date format must be 'yyyy-mm' like '2022-08'." . PHP_EOL],
            5 => ['2000-1', "Command invalid. Date format must be 'yyyy-mm' like '2022-08'." . PHP_EOL],
        ];
    }

    /**
     * @dataProvider checkFileNameDataProvider
     */
    public function testCheckFileName(string $fileName, bool|string $expected)
    {
        $this->assertEquals($expected, $this->validator->checkFileName($fileName));
    }

    public function checkFileNameDataProvider(): array
    {
        return [
            'json' => ['file.json', false],
            'csv' => ['folder/test/file.csv', false],
            'dot path' => ['./test/file.csv', false],
            'jayson' => ['file.jayson', "Command invalid. File extension must be 'json' or 'csv'." . PHP_EOL],
        ];
    }

    /**
     * @dataProvider checkSrcFileDataProvider
     */
    public function testCheckSrcFile(string $srcFile, bool|string $expected)
    {
        $this->assertEquals($expected, $this->validator->checkSrcFile($srcFile));
    }

    public function checkSrcFileDataProvider(): array
    {
        return [
            'file exist' => ['tests/jokesExample.json', false],
            'file not exist' => ['some/file.csv', "Command invalid. File does not exist: 'some/file.csv'" . PHP_EOL],
        ];
    }

    /**
     * @dataProvider checkMaxMarksPerJokeDataProvider
     */
    public function testCheckMaxMarksPerJoke(int $maxMarksPerJoke, bool|string $expected)
    {
        $this->assertEquals($expected, $this->validator->checkMaxMarksPerJoke($maxMarksPerJoke));
    }

    public function checkMaxMarksPerJokeDataProvider(): array
    {
        return [
            'max 10' => [10, false],
            'max 0' => [0, "Command invalid. 'maxMarksPerJoke' must be 1 or above." . PHP_EOL],
        ];
    }

    /**
     * @dataProvider checkMaxMarkValueDataProvider
     */
    public function testCheckMaxMarkValue(int $maxMarkValue, bool|string $expected)
    {
        $this->assertEquals($expected, $this->validator->checkMaxMarkValue($maxMarkValue));
    }

    public function checkMaxMarkValueDataProvider(): array
    {
        return [
            '10' => [10, false],
            '0' => [0, "Command invalid. 'maxMarkValue' must be above 1 and lower then 101" . PHP_EOL],
            '101' => [0, "Command invalid. 'maxMarkValue' must be above 1 and lower then 101" . PHP_EOL],
        ];
    }

    /**
     * @dataProvider checkPersonCountDataProvider
     */
    public function testCheckPersonCount(int $personCount, bool|string $expected)
    {
        $this->assertEquals($expected, $this->validator->checkPersonCount($personCount));
    }

    public function checkPersonCountDataProvider(): array
    {
        return [
            '10' => [10, false],
            '0' => [0, "Command invalid. 'personCount' must be 1 or above." . PHP_EOL],
        ];
    }

    /**
     * @dataProvider checkSourceDataProvider
     */
    public function testCheckSource(string $sourceAlias, array $cfg, bool|string $expected)
    {
        $this->assertEquals($expected, $this->validator->checkSource(
            $sourceAlias, ['CHUCKNORRIS_API_ALIAS' => 'chucknorris', 'DADJOKES_API_ALIAS' => 'dadjokes']
        ));
    }

    public function checkSourceDataProvider(): array
    {
        $cfg = ['CHUCKNORRIS_API_ALIAS' => 'chucknorris', 'DADJOKES_API_ALIAS' => 'dadjokes'];
        return [
            'chucknorris' => ['chucknorris', $cfg, false],
            'dadjokes' => ['dadjokes', $cfg, false],
            'invalid' => ['invalid', $cfg, "Command invalid. Source must be 'chucknorris' or 'dadjokes'." . PHP_EOL],
        ];
    }
}
