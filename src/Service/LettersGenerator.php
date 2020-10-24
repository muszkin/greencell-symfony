<?php
declare(strict_types=1);

namespace App\Service;


class LettersGenerator
{
    public const VOWELS = ["a", "e", "i", "o", "u", "y"];
    public const CONSONANTS = ["b", "c", "d", "f", "g", "h", "j", "k", "l", "m", "n", "p", "q", "r", "s", "t", "v", "w", "x", "z"];

    /**
     * @param bool $forceVowel
     * @param bool $forceConsonant
     * @return string
     */
    public function getLetter(bool $forceVowel = false, bool $forceConsonant = false): string
    {
        if ($forceVowel && !$forceConsonant) {
            $letters = LettersGenerator::VOWELS;
        } else if (!$forceVowel && $forceConsonant) {
            $letters = LettersGenerator::CONSONANTS;
        } else {
            $letters = array_merge(LettersGenerator::CONSONANTS, LettersGenerator::VOWELS);
        }

        return $letters[rand(0, count($letters) - 1)];
    }
}