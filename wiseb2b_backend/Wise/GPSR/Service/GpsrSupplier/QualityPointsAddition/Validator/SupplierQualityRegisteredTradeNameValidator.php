<?php

declare(strict_types=1);

namespace Wise\GPSR\Service\GpsrSupplier\QualityPointsAddition\Validator;

use Wise\GPSR\Service\GpsrSupplier\QualityPointsAddition\Validator\Interfaces\SupplierQualityValidatorInterface;

final class SupplierQualityRegisteredTradeNameValidator implements SupplierQualityValidatorInterface
{
    public function isValid(mixed $value): bool
    {
        if ($value === null) {
            return false;
        }

        if ($value === '') {
            return false;
        }

        return true;
    }
}
