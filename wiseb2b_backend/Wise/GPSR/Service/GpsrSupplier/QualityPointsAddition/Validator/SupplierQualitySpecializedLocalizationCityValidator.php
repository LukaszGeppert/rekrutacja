<?php

declare(strict_types=1);

namespace Wise\GPSR\Service\GpsrSupplier\QualityPointsAddition\Validator;

use ReflectionClass;
use Wise\Core\Model\Address;
use Wise\GPSR\Domain\GpsrSupplier\Enum\SpecializedLocalizationCityEnum;
use Wise\GPSR\Service\GpsrSupplier\QualityPointsAddition\Validator\Interfaces\SupplierQualityValidatorInterface;

final class SupplierQualitySpecializedLocalizationCityValidator implements SupplierQualityValidatorInterface
{
    public function isValid(mixed $value): bool
    {
        if ($value === null) {
            return false;
        }

        if (!$value instanceof Address) {
            return false;
        }

        return SpecializedLocalizationCityEnum::tryFrom($value->getCity()) instanceof SpecializedLocalizationCityEnum;
    }
}
