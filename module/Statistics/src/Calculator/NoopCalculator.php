<?php

declare(strict_types = 1);

namespace Statistics\Calculator;

use SocialPost\Dto\SocialPostTo;
use Statistics\Dto\StatisticsTo;

class NoopCalculator extends AbstractCalculator
{
    protected const UNITS = 'posts';

    private $postsCount = 0;

    /**
     * @var array
     */
    private $totals = [];

    /**
     * @inheritDoc
     */
    protected function doAccumulate(SocialPostTo $postTo): void
    {
        $key = $postTo->getAuthorName();

        $this->totals[$key] = ($this->totals[$key] ?? 0) + 1;

        $this->postsCount++;
    }

    /**
     * @inheritDoc
     */
    protected function doCalculate(): StatisticsTo
    {
        $averageNumberOfPostsPerUser = (count($this->totals) == 0 || $this->postsCount == 0) ? 0 : $this->postsCount / count($this->totals);

        return (new StatisticsTo())
            ->setName($this->parameters->getStatName())
            ->setValue($averageNumberOfPostsPerUser)
            ->setUnits(self::UNITS);
    }
}
