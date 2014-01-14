<?php
/*
* You are completely free to use/modify this script in any way. Credit is not required.
* Generosity is always appreciated: DNd7tFAMpnmv1UpYV9bdpjdhXwQZbEmDC2
*/
define("SIMPLE_FAUCET",true);
require_once('./lib/jsonRPCClient.php');
require_once('./lib/simple_faucet.php');
require_once('./config.php');
if (!isset($config) || !class_exists("jsonRPCClient") || !class_exists("simple_faucet"))
	die("Faucet missing core components and/or config.");
$simple_faucet = new simple_faucet($config);
$simple_faucet->render();
?>