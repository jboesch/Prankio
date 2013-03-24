<?
$dir = dirname(__FILE__);
require_once($dir . '/../lib/PrankioConfig.php');
$config = include($dir . '/config.php');
PrankioConfig::set($config);