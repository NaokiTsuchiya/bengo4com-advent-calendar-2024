<?php

declare(strict_types=1);

namespace NaokiTsuchiya\JwtSessionExample;

use DateTimeZone;
use Lcobucci\Clock\SystemClock;
use Lcobucci\JWT\JwtFacade;
use Lcobucci\JWT\Signer;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Validation\Constraint\StrictValidAt;
use Lcobucci\JWT\Validation\SignedWith as SignedWithInterface;
use Lcobucci\JWT\Validation\ValidAt;
use NaokiTsuchiya\JwtSessionExample\Attribute\Cookie;
use NaokiTsuchiya\JwtSessionExample\Attribute\SessionName;
use Psr\Clock\ClockInterface;
use Ray\Di\AbstractModule;
use SessionHandlerInterface;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\RedisSessionHandler;

class JwtSessionModule extends AbstractModule
{
    /** @inheritDoc */
    protected function configure()
    {
        // session and cookie
        $this->bind()->annotatedWith(SessionName::class)->toInstance('sess');
        $this->bind(SessionFactory::class);
        $this->bind(RequestSessionIdProvider::class);
        $this->bind()->annotatedWith(Cookie::class)->toProvider(CookieProvider::class);

        // tokenFactory
        $this->bind()->annotatedWith('issuer')->toInstance('http://localhost:8080');
        $this->bind(Issuer::class);
        $this->bind(JwtFacade::class);
        $this->bind(Key::class)->toProvider(InMemoryProvider::class);
        $this->bind(Signer::class)->to(Sha256::class);
        $this->bind(TokenFactoryInterface::class)->to(TokenFactory::class);

        // parser
        $this->bind(ParserInterface::class)->to(Parser::class);
        $this->bind(SignedWithInterface::class)->toProvider(SignedWithProvider::class);
        $this->bind(ValidAt::class)->to(StrictValidAt::class);

        // clock
        $this->bind(SystemClock::class);
        $this->bind(DateTimeZone::class)->toProvider(UtcDateTimeZoneProvider::class);
        $this->bind(ClockInterface::class)->to(SystemClock::class);

        // sessionHandler
        $this->bind()->annotatedWith('redis')->toProvider(RedisProvider::class);
        $this->bind(SessionHandlerInterface::class)->toConstructor(RedisSessionHandler::class, ['redis' => 'redis']);
    }
}
