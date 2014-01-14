<?php
/*
* You are completely free to use/modify this script in any way. Credit is not required.
* Generosity is always appreciated: KHi1Lf6Hi81yc61r5SKQMvkCMSF5s9JbSY
*/

// Modify these settings to suit your needs.

$config = array(
	// RPC settings:
	// These are the settings you put into kittehcoin.conf. They allow the faucet to interact with your wallet
	"rpc_user" => "",
	"rpc_password" => "",
	"rpc_host" => "",
	"rpc_port" => "",

	// MySQL settings:
	"mysql_user" => "",
	"mysql_password" => "",
	"mysql_host" => "",
	"mysql_database" => "", // faucet database name
	"mysql_table_prefix" => "sf_", // table prefix to use

	// MEOW values:
	"minimum_payout" => 10, // minimum MEOW to be awarded
	"maximum_payout" => 100, // maximum MEOW to be awarded
	"payout_threshold" => 400, // payout threshold, if the faucet contains less MEOW than this, display the 'dry_faucet' message
	"payout_interval" => "4h", // payout interval, the wait time for a user between payouts. Type any numerical value with either a "m" (minutes), "h" (hours), or "d" (days), attached. Examples: 50m for a 50 minute delay, 7h for a 7 hour delay, etc.

	// this option has 3 possible values: "ip_address", "kitteh_address", and "both". It defines what to check for when a user enters a kitteh address in order to decide whether or not to award MEOW to this user.
	// "ip_address": checks the user IP address in the payout history.
	// "kitteh_address": checks the user Kitteh address in the payout history.
	// "both": check both the IP and Kitteh address in the payout history.
	"user_check" => "both",

	"use_captcha" => true, // require the user to enter a captcha

	"captcha" => "recaptcha", // leave it at recaptcha simplecaptcha is rubbish.

	// if you're using reCAPTCHA, its free get the keys here: http://www.google.com/recaptcha
	"captcha_config" => array(
		"private_key" => "6LflwewSAAAAAPPxXNbXTJHjoEEVkTskQaYXJQc1",
		"public_key" => "6LflwewSAAAAAEBb0SFymTw-YfRYrNb3gi0JAHsy"
		),

	// if the wallet is encrypted, enter the PASSPHRASE here. Leave it blank otherwise!
	"wallet_passphrase" => "",

	// Donation address:
	"donation_address" => "KHi1Lf6Hi81yc61r5SKQMvkCMSF5s9JbSY", // donation address to display

	// Faucet look and feel:
	"title" => "CatNip Faucet", // page title, may be used by the template too
	"template" => "kitteh" // template to use (see the templates directory)
	);


// Do not change this.
defined("SIMPLE_FAUCET") || header(".");
?>