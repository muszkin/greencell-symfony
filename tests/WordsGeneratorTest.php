<?php

namespace App\Tests;

use App\Service\LettersGenerator;
use App\Service\WordsGenerator;
use PHPUnit\Framework\TestCase;

class WordsGeneratorTest extends TestCase
{
    public function testGenerateWord()
    {
        $wordsGenerator = new WordsGenerator(new LettersGenerator());

        $wordLength = rand(10,20);
        $firstWord = $wordsGenerator->generateWord([],$wordLength,$wordLength);
        $lettersCount = strlen($firstWord);
        $this->assertEquals($wordLength, strlen($firstWord), "Length of generated word should math passed word length.Wanted length {$wordLength}, returned {$lettersCount}. Word: {$firstWord}.");
        $this->assertContains($firstWord[0], LettersGenerator::CONSONANTS, "First letter always consonant. Word: {$firstWord}.");
        $this->assertContains($firstWord[1], LettersGenerator::VOWELS, "Second letter always vowel. Word: {$firstWord}.");

        $consonantInRow = 0;
        for ($i = 0;$i < strlen($firstWord); $i++) {
            if (in_array($firstWord[$i], LettersGenerator::CONSONANTS, true)) {
                $consonantInRow++;
            } else {
                $consonantInRow = 0;
            }
        }
        $this->assertLessThanOrEqual(2, $consonantInRow, "No more than 2 consonants in row. Word: {$firstWord}.");
    }

    public function testGenerateWords()
    {
        $wordsGenerator = new WordsGenerator(new LettersGenerator());

        $min = rand(1,10);
        $max = rand(11,20);
        $numberOfWords = rand(1,100);

        $words = $wordsGenerator->generateWords($numberOfWords, $min, $max);
        $wordsCount = count($words);
        $this->assertCount($numberOfWords, $words, "Number of generated words should match with given param. Number passed {$numberOfWords}, returned {$wordsCount}");

        foreach ($words as $word) {
            $this->assertGreaterThanOrEqual($min, strlen($word), "Generated word should not have less letters than passed minimal value. Word: {$word}.");
            $this->assertLessThanOrEqual($max, strlen($word), "Generated word should not have more letters than passed maximal value. Word: {$word}.");
        }

    }
}
