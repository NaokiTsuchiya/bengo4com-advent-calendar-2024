<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

header('Content-Type: text/plain');
http_response_code(200);

echo 'stateless';
