<?php

namespace App\Tests;

use App\Service\LettersGenerator;
use App\Service\OutputGenerator;
use App\Service\WordsGenerator;
use DateTime;
use PHPUnit\Framework\TestCase;

class OutputGeneratorTestPhpTest extends TestCase
{
    public function testWriteOutput(): void
    {
        $writeOutput = new OutputGenerator(new WordsGenerator(new LettersGenerator())); //should be mocked, but in this application size it does not matter.

        $min = rand(1,10);
        $max = rand(11,20);
        $numberOfWords = rand(1,100);

        $date = new DateTime();

        $logEntry = sprintf("[%s] Total words: %d, words length range (min,max): (%d,%d)", $date->format("Y-m-d H:i:s"), $numberOfWords, $min, $max);

        $writeOutput->writeOutput($date, $numberOfWords, $min, $max);


        $logEntries = explode("\n", file_get_contents("generator.log"));
        array_pop($logEntries); // Removing last empty line
        $lastLogEntry = array_pop($logEntries);

        self::assertEquals($logEntry, $lastLogEntry, "Last log entry should math with parameters. Log entry expected:\n{$logEntry}\nfound:\n{$lastLogEntry}");

        $generatedWords = explode("\n",file_get_contents("words.txt"));
        $numberOfGeneratedWords = count($generatedWords) - 1; // Removing last empty line
        self::assertEquals($numberOfWords, $numberOfGeneratedWords, "Number of generated words should match given parameter. Expected {$numberOfWords}, generated {$numberOfGeneratedWords}");
    }
}
