<?php

declare(strict_types=1);

namespace Wise\GPSR\Service\GpsrSupplier\QualityPointsAddition\Validator;

use ReflectionClass;
use Wise\Core\Model\Address;
use Wise\GPSR\Service\GpsrSupplier\QualityPointsAddition\Validator\Interfaces\SupplierQualityValidatorInterface;

final class SupplierQualityAddressValidator implements SupplierQualityValidatorInterface
{
    public function isValid(mixed $value): bool
    {
        if ($value === null) {
            return false;
        }

        if (!$value instanceof Address) {
            return false;
        }

        $reflectionClass = new ReflectionClass($value);

        foreach ($reflectionClass->getProperties() as $addressProperty) {
            $attributes = $addressProperty->getAttributes('Symfony\Component\Validator\Constraints\NotBlank');
            $notBlankAssertAttribute = reset($attributes);

            if ($notBlankAssertAttribute === false) {
                continue;
            }

            $propertyValue = $addressProperty->getValue($value);

            if ($propertyValue === null) {
                return false;
            }

            if ($propertyValue === '') {
                return false;
            }
        }

        return true;
    }
}
