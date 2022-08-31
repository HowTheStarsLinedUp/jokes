<?php

declare(strict_types=1);

namespace App\Commands;

use Symfony\Component\Console\Output\OutputInterface;

class CommandValidator
{
    private OutputInterface $output;

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    public function count(int $number) : bool
    {
        if ($number > 250) {
            $this->output->writeln('<error>To many jokes. Max 250.</>');
            return false;
        }

        return true;
    }

    public function date(string $date) : bool
    {
        // format Y-m: "2012-09"
        if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])$/",$date)) {
            $this->output->writeln('<error>Wrong date format. Must be like "2012-09".</>');
            return false;
        }

        return true;
    }

    public function fileName(string $fileName) : bool
    {
        $folders = explode('/', $fileName);
        $fileName = array_pop($folders);

        if (!(strpos($fileName, "."))) return false;

        $path = '';
        foreach($folders as $folder) {
            if ($folder == '.') {
                $path .= $folder;
                continue;
            }
            $path .= "/$folder";
            if (!is_dir($path)) mkdir($path);
        }

        return true;
    }

    public function source(string $sourceAlias) : bool
    {
        if ($sourceAlias == $_ENV['CHUCKNORRIS_API_ALIAS'] or $sourceAlias == $_ENV['DADJOKES_API_ALIAS']) {
            return true;
        }

        if (empty($sourceAlias)) {
            $this->output->writeln('<error>Empty source.</>');
        } else {
            $this->output->writeln('<error>Source is not valid.</>');
        }

        return false;
    }
}
