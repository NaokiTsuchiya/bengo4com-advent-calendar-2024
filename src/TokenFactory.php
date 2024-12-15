<?php

declare(strict_types=1);

namespace NaokiTsuchiya\JwtSessionExample;

use DateTimeImmutable;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\JwtFacade;
use Lcobucci\JWT\Signer;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\UnencryptedToken;

final class TokenFactory implements TokenFactoryInterface
{
    public function __construct(
        private readonly Issuer $issuer,
        private readonly JwtFacade $jwtFacade,
        private readonly Key $key,
        private readonly Signer $signer,
    ) {
    }

    public function create(string $sessionId): UnencryptedToken
    {
        return $this->jwtFacade->issue(
            $this->signer,
            $this->key,
            fn (
                Builder $builder,
                DateTimeImmutable $issuedAt,
            ): Builder => $builder
                ->issuedBy((string) $this->issuer)
                ->expiresAt($issuedAt->modify('+1 day'))
                ->identifiedBy($sessionId),
        );
    }
}
