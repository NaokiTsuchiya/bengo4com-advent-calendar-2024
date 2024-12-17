<?php

declare(strict_types=1);

namespace NaokiTsuchiya\JwtSessionExample;

use NaokiTsuchiya\JwtSessionExample\Attribute\Cookie;
use NaokiTsuchiya\JwtSessionExample\Attribute\SessionName;

use function assert;
use function is_string;

final readonly class RequestSessionIdProvider
{
    /** @param array<string, string> $cookie */
    public function __construct(
        #[SessionName]
        private string $name,
        private Parser $parser,
        #[Cookie]
        private array $cookie,
    ) {
    }

    public function get(): string|null
    {
        $sess = $this->cookie[$this->name] ?? '';
        if ($sess === '') {
            return null;
        }

        $token = $this->parser->parse($sess);

        if ($token === null) {
            return null;
        }

        $sessId = $token->claims()->get('jti');
        if (! is_string($sessId)) {
            return null;
        }

        return $sessId;
    }
}
