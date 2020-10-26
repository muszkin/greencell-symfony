<?php

namespace App\Tests;

use App\Service\LettersGenerator;
use PHPUnit\Framework\TestCase;

class LettersGeneratorTest extends TestCase
{

    /**
     * Tests if letter generated is either vowel or consonant
     */
    public function testGetLetter(): void
    {
        $lettersGenerator = new LettersGenerator();

        $vowel = $lettersGenerator->getLetter(true, false);
        self::assertContains($vowel, LettersGenerator::VOWELS, "Letter should be vowel. Letter {$vowel}.");
        self::assertNotContains($vowel, LettersGenerator::CONSONANTS,"Letter should not be vowel. Letter {$vowel}.");

        $consonant = $lettersGenerator->getLetter(false, true);
        self::assertContains($consonant, LettersGenerator::CONSONANTS, "Letter should not be vowel. Letter {$consonant}.");
        self::assertNotContains($consonant, LettersGenerator::VOWELS, "Letter should be vowel. Letter {$consonant}.");

        $vowelForceConsonantForce = $lettersGenerator->getLetter(true, true);
        self::assertContains($vowelForceConsonantForce, array_merge(LettersGenerator::CONSONANTS, LettersGenerator::VOWELS), "Letter should be vowel or consonant. Letter {$vowelForceConsonantForce}.");

        $noVowelForceNoConsonantForce = $lettersGenerator->getLetter(false, false);
        self::assertContains($noVowelForceNoConsonantForce, array_merge(LettersGenerator::CONSONANTS, LettersGenerator::VOWELS), "Letter should be vowel or consonant. Letter {$noVowelForceNoConsonantForce}.");

    }
}
