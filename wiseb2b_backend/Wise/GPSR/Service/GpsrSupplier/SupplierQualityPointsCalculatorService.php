<?php

declare(strict_types=1);

namespace Wise\GPSR\Service\GpsrSupplier;

use Wise\GPSR\ApiAdmin\Dto\GpsrSupplier\GetGpsrSupplierDto;
use Wise\GPSR\Domain\GpsrSupplier\QualityPoints;
use Wise\GPSR\Service\GpsrSupplier\QualityPointsAddition\Interfaces\QualityPointsAdditionInterface;

final class SupplierQualityPointsCalculatorService
{
    /**
     * @param QualityPointsAdditionInterface[] $qualityPointsAdditions
     */
    public function __construct(
        private readonly iterable $qualityPointsAdditions,
    ) {}

    public function calculateSupplierQualityPoints(GetGpsrSupplierDto $gpsrSupplier): QualityPoints
    {
        $qualityPoints = new QualityPoints(0);

        foreach ($this->qualityPointsAdditions as $qualityPointsAddition) {
            $qualityPoints = $qualityPoints->addQualityPoints(
                $qualityPointsAddition->getAdditionalQualityPoints($gpsrSupplier)
            );
        }

        return $qualityPoints;
    }
}
