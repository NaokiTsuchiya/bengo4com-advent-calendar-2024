<?php

declare(strict_types=1);

use Lcobucci\JWT\UnencryptedToken;
use NaokiTsuchiya\JwtSessionExample\JwtSessionModule;
use NaokiTsuchiya\JwtSessionExample\RequestSessionIdProvider;
use NaokiTsuchiya\JwtSessionExample\SessionFactory;
use NaokiTsuchiya\JwtSessionExample\TokenFactoryInterface;
use Ray\Di\Injector;

require __DIR__ . '/../vendor/autoload.php';

$injector = new Injector(new JwtSessionModule());

$sessionFactory = $injector->getInstance(SessionFactory::class);
$reqSessIdProvider = $injector->getInstance(RequestSessionIdProvider::class);
assert($sessionFactory instanceof SessionFactory);
assert($reqSessIdProvider instanceof RequestSessionIdProvider);

$reqSessionId = $reqSessIdProvider->get();
$session = $sessionFactory->createIlluminateSession($reqSessionId);

$session->start();
$session->put('key', 'value');
$session->save();

$sesId = $session->getId();

$token = null;
$body = 'Response without session cookie.';
if ($sesId !== $reqSessionId) {
    $tokenFactory = $injector->getInstance(TokenFactoryInterface::class);
    assert($tokenFactory instanceof TokenFactoryInterface);

    $token = $tokenFactory->create($sesId);
    $body = 'Response with session cookie.';
}

responseHeader($token);
responseBody($body);

function responseHeader(UnencryptedToken|null $token = null): void
{
    header('Content-Type: text/plain');
    http_response_code(200);

    if ($token) {
        $exp = $token->claims()->get('exp');
        assert($exp instanceof DateTimeImmutable);

        setcookie('sess', $token->toString(), [
            'expires' => $exp->getTimestamp(),
            'path' => '/',
            'domain' => 'localhost',
            'secure' => $_SERVER['REQUEST_SCHEME'] ?? 'http',
            'httponly' => true,
        ]);
    }
}

function responseBody(string $body): void
{
    echo $body;
}
