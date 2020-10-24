<?php

namespace App\Tests;

use App\Service\LettersGenerator;
use PHPUnit\Framework\TestCase;

class LettersGeneratorTest extends TestCase
{

    /**
     * Tests if letter generated is either vowel or consonant
     */
    public function testGetLetter()
    {
        $lettersGenerator = new LettersGenerator();

        $vowel = $lettersGenerator->getLetter(true, false);
        $this->assertContains($vowel, LettersGenerator::VOWELS, "Letter should be vowel. Letter {$vowel}.");
        $this->assertNotContains($vowel, LettersGenerator::CONSONANTS,"Letter should not be vowel. Letter {$vowel}.");

        $consonant = $lettersGenerator->getLetter(false, true);
        $this->assertContains($consonant, LettersGenerator::CONSONANTS, "Letter should not be vowel. Letter {$consonant}.");
        $this->assertNotContains($consonant, LettersGenerator::VOWELS, "Letter should be vowel. Letter {$consonant}.");

        $vowelForceConsonantForce = $lettersGenerator->getLetter(true, true);
        $this->assertContains($vowelForceConsonantForce, array_merge(LettersGenerator::CONSONANTS, LettersGenerator::VOWELS), "Letter should be vowel or consonant. Letter {$vowelForceConsonantForce}.");

        $noVowelForceNoConsonantForce = $lettersGenerator->getLetter(false, false);
        $this->assertContains($noVowelForceNoConsonantForce, array_merge(LettersGenerator::CONSONANTS, LettersGenerator::VOWELS), "Letter should be vowel or consonant. Letter {$noVowelForceNoConsonantForce}.");

    }
}
