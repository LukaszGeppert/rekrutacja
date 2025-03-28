<?php

declare(strict_types=1);

namespace Wise\GPSR\Domain\GpsrSupplier\Enum;

enum QualityPointRateEnum
{
    public const TAX_NUMBER = 10;
    public const EMAIL = 10;
    public const REGISTERED_TRADE_NAME = 5;
    public const ADDRESS = 10;
    public const PHONE = 5;
    public const TRUSTED_DOMAIN_EMAIL = 5;
    public const SPECIALIZED_LOCATION = 5;
}
