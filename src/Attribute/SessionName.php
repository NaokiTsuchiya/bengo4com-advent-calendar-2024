<?php

declare(strict_types=1);

namespace NaokiTsuchiya\JwtSessionExample\Attribute;

use Attribute;
use Ray\Di\Di\Qualifier;

#[Attribute]
#[Qualifier]
final class SessionName
{
}
