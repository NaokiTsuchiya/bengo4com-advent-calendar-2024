<?php

declare(strict_types=1);

use Lcobucci\JWT\UnencryptedToken;
use NaokiTsuchiya\JwtSessionExample\JwtSessionModule;
use NaokiTsuchiya\JwtSessionExample\RequestSessionIdProvider;
use NaokiTsuchiya\JwtSessionExample\SessionFactory;
use Ray\Di\Injector;

require __DIR__ . '/../vendor/autoload.php';

$injector = new Injector(new JwtSessionModule());

$sessionFactory = $injector->getInstance(SessionFactory::class);
$reqSessIdProvider = $injector->getInstance(RequestSessionIdProvider::class);
assert($sessionFactory instanceof SessionFactory);
assert($reqSessIdProvider instanceof RequestSessionIdProvider);

$reqSessionId = $reqSessIdProvider->get();
if ($reqSessionId === null) {
    responseHeader(400);
    responseBody('Session required.');

    return;
}

$session = $sessionFactory->createIlluminateSession($reqSessionId);

$session->start();
$value = $session->get('key');
assert(is_string($value));
$session->save();

$sesId = $session->getId();

responseHeader();
responseBody('Session value: ' . $value);

function responseHeader(int $code = 200, UnencryptedToken|null $token = null): void
{
    header('Content-Type: text/plain');
    http_response_code($code);

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
