<?php

use NaokiTsuchiya\JwtSessionExample\JwtSessionModule;
use Ray\ObjectGrapher\ObjectGrapher;

require dirname(__DIR__) . '/vendor/autoload.php';

$dot = (new ObjectGrapher())(new JwtSessionModule());
file_put_contents('object-graph.dot', $dot);
