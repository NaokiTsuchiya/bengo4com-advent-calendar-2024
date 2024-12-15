<?php

declare(strict_types=1);

namespace NaokiTsuchiya\JwtSessionExample;

use Ray\Di\ProviderInterface;
use Redis;

/** @implements ProviderInterface<Redis> */
class RedisProvider implements ProviderInterface
{
    /** @inheritDoc */
    public function get()
    {
        $redis = new Redis();

        $redis->connect('127.0.0.1');
        $redis->select(0);

        return $redis;
    }
}
