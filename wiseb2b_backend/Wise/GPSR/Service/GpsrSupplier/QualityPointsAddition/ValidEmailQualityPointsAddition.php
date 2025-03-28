<?php

declare(strict_types=1);

namespace Wise\GPSR\Service\GpsrSupplier\QualityPointsAddition;

use Wise\GPSR\ApiAdmin\Dto\GpsrSupplier\GetGpsrSupplierDto;
use Wise\GPSR\Domain\GpsrSupplier\Enum\QualityPointRateEnum;
use Wise\GPSR\Domain\GpsrSupplier\QualityPoints;
use Wise\GPSR\Service\GpsrSupplier\QualityPointsAddition\Interfaces\QualityPointsAdditionInterface;
use Wise\GPSR\Service\GpsrSupplier\QualityPointsAddition\Validator\SupplierQualityEmailValidator;

final class ValidEmailQualityPointsAddition implements QualityPointsAdditionInterface
{
    public function __construct(
        private readonly SupplierQualityEmailValidator $supplierQualityEmailValidator,
    ) {}

    public function getAdditionalQualityPoints(GetGpsrSupplierDto $gpsrSupplier): QualityPoints
    {
        if (!$this->supplierQualityEmailValidator->isValid($gpsrSupplier->getEmail())) {
            return new QualityPoints(0);
        }

        return new QualityPoints(QualityPointRateEnum::EMAIL);
    }
}
