<?php

declare(strict_types=1);

namespace Wise\GPSR\Service\GpsrSupplier\QualityPointsAddition;

use Wise\GPSR\ApiAdmin\Dto\GpsrSupplier\GetGpsrSupplierDto;
use Wise\GPSR\Domain\GpsrSupplier\Enum\QualityPointRateEnum;
use Wise\GPSR\Domain\GpsrSupplier\QualityPoints;
use Wise\GPSR\Service\GpsrSupplier\QualityPointsAddition\Interfaces\QualityPointsAdditionInterface;
use Wise\GPSR\Service\GpsrSupplier\QualityPointsAddition\Validator\SupplierQualityRegisteredTradeNameValidator;

final class ValidRegisteredTradeNameQualityPointsAddition implements QualityPointsAdditionInterface
{
    public function __construct(
        private readonly SupplierQualityRegisteredTradeNameValidator $supplierQualityRegisteredTradeNameValidator,
    ) {}

    public function getAdditionalQualityPoints(GetGpsrSupplierDto $gpsrSupplier): QualityPoints
    {
        if (!$this->supplierQualityRegisteredTradeNameValidator->isValid($gpsrSupplier->getRegisteredTradeName())) {
            return new QualityPoints(0);
        }

        return new QualityPoints(QualityPointRateEnum::REGISTERED_TRADE_NAME);
    }
}
