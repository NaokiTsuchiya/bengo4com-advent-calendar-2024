<?php

declare(strict_types=1);

namespace NaokiTsuchiya\JwtSessionExample;

use DateTimeZone;
use Ray\Di\ProviderInterface;

/** @implements ProviderInterface<DateTimeZone> */
final class UtcDateTimeZoneProvider implements ProviderInterface
{
    /** @return DateTimeZone */
    public function get()
    {
        return new DateTimeZone('UTC');
    }
}
