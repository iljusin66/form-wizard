<?php
mb_internal_encoding("UTF-8");

use Latecka\Config\config;
use Latecka\formWizard;
use Latecka\Utils\utils;

require_once 'vendor/autoload.php';
new config();
$fw = new formWizard();
$fw->dbTableSchema('app_role');





