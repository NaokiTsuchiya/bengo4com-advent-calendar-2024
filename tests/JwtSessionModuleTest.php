<?php

declare(strict_types=1);

namespace NaokiTsuchiya\JwtSessionExample;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Ray\Di\Injector;

final class JwtSessionModuleTest extends TestCase
{
    private Injector $injector;

    protected function setUp(): void
    {
        $this->injector = new Injector(new JwtSessionModule());
    }

    #[Test]
    public function newInstanceOfTokenFactory(): void
    {
        $instance = $this->injector->getInstance(TokenFactory::class);
        $this->assertInstanceOf(TokenFactory::class, $instance);
    }

    #[Test]
    public function newInstanceOfSessionFactory(): void
    {
        $instance = $this->injector->getInstance(SessionFactory::class);

        $this->assertInstanceOf(SessionFactory::class, $instance);
    }

    #[Test]
    public function testInstanceOfRequestSessionIdProvider(): void
    {
        $instance = $this->injector->getInstance(RequestSessionIdProvider::class);

        $this->assertInstanceOf(RequestSessionIdProvider::class, $instance);
    }

    #[Test]
    public function testCreateToken(): void
    {
        $app = $this->injector->getInstance(App::class);
        $session = $app->sessionFactory->newInstance(null);
        $token = $app->tokenFactory->newInstance($session->getId());

        $this->assertSame($token->claims()->get('jti'), $session->getId());
    }
}
