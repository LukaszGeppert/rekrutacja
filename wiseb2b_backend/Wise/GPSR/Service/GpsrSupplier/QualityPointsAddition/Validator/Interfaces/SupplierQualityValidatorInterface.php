<?php

declare(strict_types=1);

namespace Wise\GPSR\Service\GpsrSupplier\QualityPointsAddition\Validator\Interfaces;

interface SupplierQualityValidatorInterface
{
    public function isValid(mixed $value): bool;
}
