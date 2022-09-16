<?php

declare(strict_types=1);

namespace App\Commands;

class CommandValidator
{
    public function checkCount(int $count): bool|string
    {
        return ($count > 250 or $count < 1) ? "Command invalid. 'count' must be above 1 and lower then 251".PHP_EOL : false;
    }

    public function checkDate(string $date): bool|string
    {
        // format yyyy-mm: "2012-12"
        return (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])$/", $date)) ? false : "Command invalid. Date format must be 'yyyy-mm' like '2022-08'.".PHP_EOL;
    }

    public function checkFileName(string $fileName): bool|string
    {
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        return ($ext == 'json' or $ext == 'csv') ? false : "Command invalid. File extension must be 'json' or 'csv'.".PHP_EOL;
    }

    public function checkSrcFile(string $jokesSrcFile): bool|string
    {
        return (file_exists($jokesSrcFile)) ? false : "Command invalid. File does not exist: '$jokesSrcFile'".PHP_EOL;
    }

    public function checkMaxMarksPerJoke(int $maxMarksPerJoke): bool|string
    {
        return ($maxMarksPerJoke < 1) ? "Command invalid. 'maxMarksPerJoke' must be 1 or above.".PHP_EOL : false;
    }

    public function checkMaxMarkValue(int $maxMarkValue): bool|string
    {
        return ($maxMarkValue > 100 or $maxMarkValue < 1) ? "Command invalid. 'maxMarkValue' must be above 1 and lower then 101".PHP_EOL : false;
    }

    public function checkPersonCount(int $personCount): bool|string
    {
        return ($personCount < 1) ? "Command invalid. 'personCount' must be 1 or above.".PHP_EOL : false;
    }

    public function checkSource(string $sourceAlias, array $cfg): bool|string
    {
        return ($sourceAlias == $cfg['CHUCKNORRIS_API_ALIAS'] or $sourceAlias == $_ENV['DADJOKES_API_ALIAS']) ?
            false :
            "Command invalid. Source must be '".$cfg['CHUCKNORRIS_API_ALIAS']."' or '".$_ENV['DADJOKES_API_ALIAS']."'.".PHP_EOL;
    }
}
