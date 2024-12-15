<?php

declare(strict_types=1);

namespace NaokiTsuchiya\JwtSessionExample;

use Lcobucci\JWT\UnencryptedToken;

interface ParserInterface
{
    /** @param non-empty-string $token */
    public function parse(string $token): UnencryptedToken|null;
}
