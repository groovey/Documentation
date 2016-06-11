<?php

require_once 'vendor/autoload.php';

$c = file_get_contents('./docs/markdown/README.md');

$Parsedown = new Parsedown();

$t = $Parsedown->text($c);

file_put_contents('test.html', $t);
