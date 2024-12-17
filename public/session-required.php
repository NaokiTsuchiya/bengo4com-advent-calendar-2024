<?php

declare(strict_types=1);

use NaokiTsuchiya\JwtSessionExample\App;
use NaokiTsuchiya\JwtSessionExample\JwtSessionModule;
use Ray\Di\Injector;

require __DIR__ . '/../vendor/autoload.php';

$injector = new Injector(new JwtSessionModule());

$app = $injector->getInstance(App::class);
assert($app instanceof App);
$reqSessionId = $app->reqSessIdProvider->get();

if ($reqSessionId === null) {
    header('Content-Type: text/plain');
    http_response_code(400);
    echo 'Session required.';

    return;
}

$session = $app->sessionFactory->newInstance($reqSessionId);

$session->start();
$value = $session->get('key', 'default');
$session->save();

$sessId = $session->getId();

// JWT を生成
$token = $app->tokenFactory->newInstance($sessId);
$exp = $token->claims()->get('exp');
assert($exp instanceof DateTimeImmutable);

header('Content-Type: text/plain');
http_response_code(200);
setcookie('sess', $token->toString(), [
    'expires' => $exp->getTimestamp(),
    'path' => '/',
    'domain' => 'localhost',
    'secure' => false,
    'httponly' => true,
]);;
echo 'Session value: ' . $value;
