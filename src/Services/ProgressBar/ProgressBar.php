<?php

namespace Batyukovstudio\BatMedia\Services\ProgressBar;

use Batyukovstudio\BatMedia\Contracts\ProgressBar\ProgressBarInterface;
use Symfony\Component\Console\Helper\ProgressBar as SymfonyProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class ProgressBar implements ProgressBarInterface
{
    private SymfonyProgressBar $progressBar;

    public function __construct(int $max = 0, float $minSecondsBetweenRedraws = 1 / 25)
    {
        $output = app(ConsoleOutput::class);
        $this->progressBar = new SymfonyProgressBar($output, $max, $minSecondsBetweenRedraws);
    }

    public function start(?int $max = null, int $startAt = 0): void
    {
        $this->progressBar->start($max, $startAt);
    }

    public function advance(int $step = 1): void
    {
        $this->progressBar->advance($step);
    }

    public function finish(): void
    {
        $this->progressBar->finish();
        echo "\n";
    }

}
