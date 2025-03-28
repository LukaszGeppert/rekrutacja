<?php

declare(strict_types=1);

namespace Wise\GPSR\Domain\GpsrSupplier\Enum;

enum TrustedDomainEnum: string
{
    case EXAMPLE_COM = 'example.com';
    case MY_COMPANY_EU = 'my-company.eu';
    case WISE_B2B_EU = 'wiseb2b.eu';
}
