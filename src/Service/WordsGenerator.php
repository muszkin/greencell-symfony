<?php
declare(strict_types=1);

namespace App\Service;


class WordsGenerator
{
    /**
     * @var LettersGenerator
     */
    private $lettersGenerator;

    public function __construct(LettersGenerator $lettersGenerator) {
        $this->lettersGenerator = $lettersGenerator;
    }

    public function generateWords(int $numWords, int $minLetters, int $maxLetters): array
    {
        $words = [];
        for ($i = 0; $i < $numWords; $i++) {
            $words[] = $this->generateWord($words, $minLetters, $maxLetters);
        }
        return $words;
    }

    public function generateWord(array $generatedWords, int $minLetters, int $maxLetters): string
    {
        $word = "";
        $letters = rand($minLetters, $maxLetters);
        for ($i = 0; $i < $letters; $i++) {
            if (strlen($word) === 0) {
                $word .= $this->lettersGenerator->getLetter(false, true);
                continue;
            }
            if ((strlen($word) === 1) || (strlen($word) >= 2 && !in_array($word[strlen($word) - 1], LettersGenerator::VOWELS) && !in_array($word[strlen($word) - 2], LettersGenerator::VOWELS))) {
                $word .= $this->lettersGenerator->getLetter(true, false);
            } else {
                $word .= $this->lettersGenerator->getLetter();
            }
        }
        if (in_array($word, $generatedWords)) {
            return $this->generateWord($generatedWords, $minLetters, $maxLetters);
        } else {
            return $word;
        }
    }
}