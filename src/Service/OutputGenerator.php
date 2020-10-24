<?php
declare(strict_types=1);

namespace App\Service;


use DateTime;

class OutputGenerator
{
    /**
     * @var WordsGenerator
     */
    private $generator;

    public function __construct(WordsGenerator $generator)
    {
        $this->generator = $generator;
    }

    function writeOutput(DateTime $date, int $numWords, int $minLetters, int $maxLetters): void
    {
        $generatorLogFile = fopen("generator.log", 'a+');
        $wordsLogFile = fopen("words.log", 'w+');
        $logEntry = sprintf("[%s] Total words: %d, words length range (min,max): (%d,%d)\n", $date->format("Y-m-d H:i:s"), $numWords, $minLetters, $maxLetters);
        fwrite($generatorLogFile, $logEntry);
        fclose($generatorLogFile);
        $words = $this->generator->generateWords($numWords, $minLetters, $maxLetters);
        foreach ($words as $word) {
            fwrite($wordsLogFile, "$word\n");
        }
        fclose($wordsLogFile);
    }}