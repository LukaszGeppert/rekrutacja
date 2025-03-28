<?php

declare(strict_types=1);

namespace Wise\GPSR\Service\GpsrSupplier\QualityPointsAddition\Validator;

use Wise\GPSR\Service\GpsrSupplier\QualityPointsAddition\Validator\Interfaces\SupplierQualityValidatorInterface;

final class SupplierQualityEmailValidator implements SupplierQualityValidatorInterface
{
    public function isValid(mixed $value): bool
    {
        if ($value === null) {
            return false;
        }

        if (preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', (string)$value) !== 1) {
            return false;
        }

        return true;
    }
}
