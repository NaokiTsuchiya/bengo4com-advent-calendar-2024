<?php

declare(strict_types=1);

namespace NaokiTsuchiya\JwtSessionExample;

use Lcobucci\JWT\JwtFacade;
use Lcobucci\JWT\Token\InvalidTokenStructure;
use Lcobucci\JWT\UnencryptedToken;
use Lcobucci\JWT\Validation\RequiredConstraintsViolated;
use Lcobucci\JWT\Validation\SignedWith;
use Lcobucci\JWT\Validation\ValidAt;

class Parser
{
    public function __construct(
        private readonly JwtFacade $jwtFacade,
        private readonly SignedWith $signedWith,
        private readonly ValidAt $validAt,
    ) {
    }

    /** @param non-empty-string $token */
    public function parse(string $token): UnencryptedToken|null
    {
        try {
            $token = $this->jwtFacade->parse(
                $token,
                $this->signedWith,
                $this->validAt,
            );
        } catch (RequiredConstraintsViolated | InvalidTokenStructure) {
            return null;
        }

        return $token;
    }
}
