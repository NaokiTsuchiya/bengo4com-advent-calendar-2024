<?php

declare(strict_types=1);

namespace NaokiTsuchiya\JwtSessionExample;

use Lcobucci\JWT\Signer;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Lcobucci\JWT\Validation\SignedWith as SignedWithInterface;
use Ray\Di\ProviderInterface;

/** @implements ProviderInterface<SignedWithInterface> */
final class SignedWithProvider implements ProviderInterface
{
    public function __construct(
        private readonly Signer $sha256,
        private readonly Key $key,
    ) {
    }

    /** @inheritDoc */
    public function get()
    {
        return new SignedWith($this->sha256, $this->key);
    }
}
