<?php

namespace Batyukovstudio\BatMedia\Contracts\ProgressBar;

interface ProgressBarInterface
{
    public function __construct(int $max = 0, float $minSecondsBetweenRedraws = 1 / 25);
    public function start(?int $max = null, int $startAt = 0): void;
    public function advance(int $step = 1): void;
    public function finish(): void;
}