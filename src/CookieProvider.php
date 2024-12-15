<?php

declare(strict_types=1);

namespace NaokiTsuchiya\JwtSessionExample;

use Ray\Di\ProviderInterface;

/** @implements ProviderInterface<array<string, string>> */
final class CookieProvider implements ProviderInterface
{
    /** @inheritDoc */
    public function get()
    {
        return $_COOKIE;
    }
}
