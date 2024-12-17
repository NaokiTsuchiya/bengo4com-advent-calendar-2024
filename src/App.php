<?php

namespace NaokiTsuchiya\JwtSessionExample;

final readonly class App
{
    public function __construct(
        public SessionFactory $sessionFactory,
        public RequestSessionIdProvider $reqSessIdProvider,
        public TokenFactory $tokenFactory,
    ) {
    }
}
