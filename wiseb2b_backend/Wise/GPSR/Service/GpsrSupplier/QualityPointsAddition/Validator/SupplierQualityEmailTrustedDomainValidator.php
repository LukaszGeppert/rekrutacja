<?php

declare(strict_types=1);

namespace Wise\GPSR\Service\GpsrSupplier\QualityPointsAddition\Validator;

use Wise\GPSR\Domain\GpsrSupplier\Enum\TrustedDomainEnum;
use Wise\GPSR\Service\GpsrSupplier\QualityPointsAddition\Validator\Interfaces\SupplierQualityValidatorInterface;

final class SupplierQualityEmailTrustedDomainValidator implements SupplierQualityValidatorInterface
{
    public function isValid(mixed $value): bool
    {
        if ($value === null) {
            return false;
        }

        return TrustedDomainEnum::tryFrom(
            $this->getEmailSuffix((string)$value)
            ) instanceof TrustedDomainEnum;
    }

    private function getEmailSuffix(string $value): string
    {
        return substr($value, (int)strpos($value, '@')+1);
    }
}
