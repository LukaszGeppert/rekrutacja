<?php

declare(strict_types=1);

namespace Wise\GPSR\Service\GpsrSupplier\QualityPointsAddition;

use Wise\GPSR\ApiAdmin\Dto\GpsrSupplier\GetGpsrSupplierDto;
use Wise\GPSR\Domain\GpsrSupplier\Enum\QualityPointRateEnum;
use Wise\GPSR\Domain\GpsrSupplier\QualityPoints;
use Wise\GPSR\Service\GpsrSupplier\QualityPointsAddition\Interfaces\QualityPointsAdditionInterface;
use Wise\GPSR\Service\GpsrSupplier\QualityPointsAddition\Validator\SupplierQualityEmailTrustedDomainValidator;

final class EmailTrustedDomainQualityPointsAddition implements QualityPointsAdditionInterface
{
    public function __construct(
        private readonly SupplierQualityEmailTrustedDomainValidator $supplierQualityEmailTrustedDomainValidator,
    ) {}

    public function getAdditionalQualityPoints(GetGpsrSupplierDto $gpsrSupplier): QualityPoints
    {
        if (!$this->supplierQualityEmailTrustedDomainValidator->isValid($gpsrSupplier->getEmail())) {
            return new QualityPoints(0);
        }

        return new QualityPoints(QualityPointRateEnum::TRUSTED_DOMAIN_EMAIL);
    }
}
