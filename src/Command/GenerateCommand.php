<?php

namespace App\Command;

use App\Service\OutputGenerator;
use DateTime;
use InvalidArgumentException;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GenerateCommand extends Command
{
    protected static $defaultName = 'generate';
    /**
     * @var OutputGenerator
     */
    private $outputGenerator;

    public function __construct(OutputGenerator $outputGenerator, string $name = null)
    {
        parent::__construct($name);
        $this->outputGenerator = $outputGenerator;
    }

    protected function configure()
    {
        $this
            ->setDescription('Generate words of length in given range. This command will run only between Monday 10:00 and Friday 15:00')
            ->addOption('words', "w", InputOption::VALUE_REQUIRED, 'Number of words to generate')
            ->addOption('from', "f", InputOption::VALUE_REQUIRED, 'Minimal number of letters in word')
            ->addOption('to', "t", InputOption::VALUE_REQUIRED, 'Maximal number of letters in word')
            ->addOption('force', null, InputOption::VALUE_NONE, 'Force generate words outside working hours.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $force = $input->getOption('force');

        $date = new DateTime();
        $weekDay = (int)$date->format("N");
        $hour = (int)$date->format("G");

        if (!$force) {
            if (($weekDay === 6 || $weekDay === 7)
                || ($weekDay === 5 && $hour > 15)
                || ($weekDay === 1 && $hour < 10)) {
                $io->error("You can't run script between Friday 15.00 and Monday 10:00");
                throw new RuntimeException("You can't run script between Friday 15.00 and Monday 10:00");
            }
        }

        $words = (int)$input->getOption('words');
        $min = (int)$input->getOption('from');
        $max = (int)$input->getOption('to');

        if ($words < 1) {
            $io->error("Words need to be integer higher than 0");
            throw new InvalidArgumentException("Words need to be integer higher than 0");
        }

        if ($min < 1) {
            $io->error("Minimal number of letters should be integer higher than 0");
            throw new InvalidArgumentException("Minimal number of letter should be integer higher than 0");
        }

        if ($max < 1) {
            $io->error("Maximal number of letters should be integer higher than 0");
            throw new InvalidArgumentException("Minimal number of letter should be integer higher than 0");
        }

        if ($max < $min) {
            $io->error("Maximal number of letters should be higher or equal minimal number of letters");
            throw new InvalidArgumentException("Maximal number of letters should be higher or equal minimal number of letters");
        }

        $this->outputGenerator->writeOutput($date, $words, $min, $max);

        return Command::SUCCESS;
    }
}
