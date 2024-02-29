<?php
require_once 'utils.php';

use Latecka\Utils\utils;

new utils();

if (!function_exists('debug')) {
    function debug($val) {
        utils::debug($val);
    }
}