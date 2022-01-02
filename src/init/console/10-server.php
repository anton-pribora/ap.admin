<?php

if (!isset($_SERVER)) {
    $_SERVER = [];
}

foreach (Config()->get('console._SERVER', []) as $key => $value) {
    $_SERVER[$key] = $value;
}