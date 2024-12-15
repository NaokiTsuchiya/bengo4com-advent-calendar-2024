<?php

declare(strict_types=1);

namespace NaokiTsuchiya\JwtSessionExample;

use Lcobucci\JWT\Signer\Key\InMemory;
use Ray\Di\ProviderInterface;

/** @implements ProviderInterface<InMemory> */
final class InMemoryProvider implements ProviderInterface
{
    /** @inheritDoc */
    public function get()
    {
        return InMemory::base64Encoded('hiG8DlOKvtih6AxlZn5XKImZ06yu8I3mkOzaJrEuW8yAv8Jnkw330uMt8AEqQ5LB');
    }
}
