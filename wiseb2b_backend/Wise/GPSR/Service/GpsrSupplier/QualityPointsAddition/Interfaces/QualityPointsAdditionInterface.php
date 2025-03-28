<?php

declare(strict_types=1);

namespace Wise\GPSR\Service\GpsrSupplier\QualityPointsAddition\Interfaces;

use Wise\GPSR\ApiAdmin\Dto\GpsrSupplier\GetGpsrSupplierDto;
use Wise\GPSR\Domain\GpsrSupplier\QualityPoints;

interface QualityPointsAdditionInterface
{
    public function getAdditionalQualityPoints(GetGpsrSupplierDto $gpsrSupplier): QualityPoints;
}
