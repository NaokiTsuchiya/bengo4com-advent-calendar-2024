<?php

declare(strict_types=1);

namespace NaokiTsuchiya\JwtSessionExample;

use Lcobucci\JWT\UnencryptedToken;

interface TokenFactoryInterface
{
    /** @param non-empty-string $sessionId */
    public function create(string $sessionId): UnencryptedToken;
}
