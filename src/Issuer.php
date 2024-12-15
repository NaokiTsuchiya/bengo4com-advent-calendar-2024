<?php

declare(strict_types=1);

namespace NaokiTsuchiya\JwtSessionExample;

use Ray\Di\Di\Named;
use Stringable;

final class Issuer implements Stringable
{
    /** @param non-empty-string $value */
    public function __construct(
        #[Named('issuer')]
        public readonly string $value,
    ) {
    }

    /** @return non-empty-string */
    public function __toString(): string
    {
        return $this->value;
    }
}
