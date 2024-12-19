<?php

use NaokiTsuchiya\JwtSessionExample\App;
use NaokiTsuchiya\JwtSessionExample\JwtSessionModule;
use Ray\Di\Injector;

require __DIR__ . '/../vendor/autoload.php';

$injector = new Injector(new JwtSessionModule());

$app = $injector->getInstance(App::class);

$reqSessionId = $app->reqSessIdProvider->get(); // セッション Cookie からセッション ID を取得
$session = $app->sessionFactory->newInstance($reqSessionId); // Illuminate\Session\Store のインスタンスを生成

// セッションに値を格納
$session->start();
$session->put('key', 'value');
$session->save();

$sessId = $session->getId(); // セッション ID を取得

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
    'secure' => false, // HTTPS 環境では true にする必要がある
    'httponly' => true,
]);

echo 'OK';
