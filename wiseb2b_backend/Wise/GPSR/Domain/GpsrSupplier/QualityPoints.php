<?php

declare(strict_types=1);

namespace Wise\GPSR\Domain\GpsrSupplier;

final class QualityPoints
{
    public function __construct(
        private readonly int $qualityPoints,
    ) {}

    public function getQualityPoints(): int
    {
        return $this->qualityPoints;
    }

    public function getQualityText(): string
    {
        if ($this->qualityPoints >= 35) {
            return 'High Quality';
        }

        if ($this->qualityPoints <= 34 && $this->qualityPoints >= 20) {
            return 'Medium Quality';
        }

        return 'Low Quality';
    }

    public function addQualityPoints(QualityPoints $qualityPointsToAdd): QualityPoints
    {
        return new self(
            $this->qualityPoints + $qualityPointsToAdd->getQualityPoints()
        );
    }
}
