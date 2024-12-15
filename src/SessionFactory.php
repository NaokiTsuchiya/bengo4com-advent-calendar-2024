<?php

declare(strict_types=1);

namespace NaokiTsuchiya\JwtSessionExample;

use Illuminate\Contracts\Session\Session;
use Illuminate\Session\Store;
use NaokiTsuchiya\JwtSessionExample\Attribute\SessionName;
use SessionHandlerInterface;

class SessionFactory
{
    public function __construct(
        #[SessionName]
        private readonly string $name,
        private readonly SessionHandlerInterface $sessionHandler,
    ) {
    }

    public function createIlluminateSession(string|null $sessionId): Session
    {
        return new Store(
            $this->name,
            $this->sessionHandler,
            $sessionId,
        );
    }
}
