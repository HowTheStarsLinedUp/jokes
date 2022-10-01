<?php

declare(strict_types=1);

namespace Unit\File;

use App\DotEnvWrapper;
use App\File\CsvReader;
use PHPUnit\Framework\TestCase;

class CsvReaderTest extends TestCase
{
    public function testCsvReader()
    {
        $expected = array (
            0 => array (
                'sourceId' => '9ovbd5b1t66_x92jwrq1yq',
                'text' => 'Chuck Norris once rode a bull, and nine months later it had a calf.',
                'category' => 'animal',
                'source' => 'chucknorris.io',
            ),
            1 => array (
                'sourceId' => 'cwguxfhptcuagndjdt1hya',
                'text' => 'In the beginning there was nothing...then Chuck Norris Roundhouse kicked that nothing in the face and said "Get a job". That is the story of the universe.',
                'category' => 'career',
                'source' => 'chucknorris.io',
            ),
            2 => array (
                'sourceId' => 'qqu1j77sqfkr-pekzhnk_q',
                'text' => 'Everything King Midas touches turnes to gold. Everything Chuck Norris touches turns up dead.',
                'category' => 'celebrity',
                'source' => 'chucknorris.io',
            ),
            3 => array (
                'sourceId' => 'jfbsb24mtawqb-s5zlx8mg',
                'text' => 'Chuck Norris does not code in cycles, he codes in strikes.',
                'category' => 'dev',
                'source' => 'chucknorris.io',
            ),
            4 => array (
                'sourceId' => 'OSlTqFsNTPaYcnF5HRUKlw',
                'text' => 'When Chuck Norris goes into a bar, he likes to have his whiskey mixed with a little 72 oz. steak, five bullet fired fresh from an AK 47, piss from an agitated rattle snake and a slice of lemon. He squirts the lemon juice directly in his eyes before drinking the entire thing of whiskey, yelling, "CHUCK NORRIS HORNY!!" and then killing everyone in the bar with his overgrown mammoth of a penis.',
                'category' => 'explicit',
                'source' => 'chucknorris.io',
            ),
            5 => array (
                'sourceId' => '0wdewlp2tz-mt_upesvrjw',
                'text' => 'Chuck Norris does not follow fashion trends, they follow him. But then he turns around and kicks their ass. Nobody follows Chuck Norris.',
                'category' => 'fashion',
                'source' => 'chucknorris.io',
            ),
            6 => array (
                'sourceId' => '60dd35aba115ee7ff4c407dd',
                'text' => 'Setup: A guy said to his girlfriend before breaking up, "A relationship is like a fart." Punchline: "How is that?" She mockingly said.  He then replied, "If you have to force it, it\'s probably crap anyway."',
                'category' => 'break',
                'source' => 'dad-jokes.p.rapidapi.com',
            ),
            7 => array (
                'sourceId' => '60dd364d7251117d2e7e98b7',
                'text' => 'Setup: I like my girls like my file system... Punchline: FAT and 16.',
                'category' => 'file',
                'source' => 'dad-jokes.p.rapidapi.com',
            ),
            8 => array (
                'sourceId' => '60dd37bdff96470c011c87cf',
                'text' => 'Setup: Two trees are sitting in a forest in the middle of summer Punchline: One turns to the other and says \'It\'s hot as balsa here\'',
                'category' => 'summer',
                'source' => 'dad-jokes.p.rapidapi.com',
            ),
            9 => array (
                'sourceId' => '60dd38021dfc729d22050fe1',
                'text' => 'Setup: I tried to find volunteers for a tug of war game during a party, but failed miserably Punchline: The good players just won\'t come forward.',
                'category' => 'war',
                'source' => 'dad-jokes.p.rapidapi.com',
            ),
            10 => array (
                'sourceId' => '60dd37b68edad440552c291e',
                'text' => 'Setup: Guy goes to a doctor and says I\'m really sick, don\'t know what\'s wrong with me. Doctor says wow, I don\'t know what this is - so I will need a stool sample, a urine specimen, and and sperm sample. Punchline: Guy says, Doc I\'m kind of in a hurry. Can I just leave you my shorts?',
                'category' => 'stool',
                'source' => 'dad-jokes.p.rapidapi.com',
            ),
            11 => array (
                'sourceId' => '60dd358a37134ec38edeb820',
                'text' => 'Setup: Not to brag, but my wife hasn’t won argument with me since... Punchline: 14-December-2020',
                'category' => 'argument',
                'source' => 'dad-jokes.p.rapidapi.com',
            ),
        );
        $dotEnv= new DotEnvWrapper();
        $dotEnv->init();
        $jokesDstFile = $dotEnv->projectDir . DIRECTORY_SEPARATOR . 'tests' . DIRECTORY_SEPARATOR . 'jokesExample.csv';
        $jokes = (new CsvReader())->read($jokesDstFile);
        $this->assertEquals($expected, $jokes);
    }
}
