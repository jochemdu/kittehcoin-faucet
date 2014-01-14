<?php
/*
* You are completely free to use/modify this script in any way. Credit is not required.
* Generosity is always appreciated: KHi1Lf6Hi81yc61r5SKQMvkCMSF5s9JbSY
*/

class simple_faucet
	{
	protected $config;

	protected $rpc_client = false;
	protected $db = false;

	protected $status = 0;

	protected $payout_amount = 0;
	protected $payout_address = "";

	protected $balance = 0;
	protected $total_donated = 0;


	public function __construct($config)
		{
		if (!defined("SF_STATUS_OPERATIONAL"))
			{
			define("SF_STATUS_OPERATIONAL",100);
			define("SF_STATUS_PAYOUT_ACCEPTED",101);
			//define("SF_STATUS_SUCCESS",102);

			define("SF_STATUS_RPC_CONNECTION_FAILED",200);
			define("SF_STATUS_MYSQL_CONNECTION_FAILED",201);
			define("SF_STATUS_PAYOUT_DENIED",202);
			define("SF_STATUS_INVALID_KITTEH_ADDRESS",203);
			define("SF_STATUS_PAYOUT_ERROR",204);
			define("SF_STATUS_CAPTCHA_INCORRECT",205);
			define("SF_STATUS_DRY_FAUCET",206);
			define("SF_STATUS_BANNED_IP;",207);

			define("SF_STATUS_FAUCET_INCOMPLETE",300);
			}
		$defaults = array(
			"minimum_payout" => 0.01,
			"maximum_payout" => 10,
			"payout_threshold" => 250,
			"payout_interval" => "7h",
			"total_donated" => 0,
			"user_check" => "both",
			"wallet_passphrase" => "",
			"use_captcha" => true,
			"captcha" => "simple-captcha",
			"captcha_config" => array(),
			"mysql_table_prefix" => "sf_",
			"donation_address" => "KHi1Lf6Hi81yc61r5SKQMvkCMSF5s9JbSY",
			"title" => "Kitteh Faucet",
			"template" => "default",

			// "captchas" => array(
			// 	"simple-captcha" => array(
			// 		"include" => "simple-captcha/simple-php-captcha.php",
			// 		""
			// 		)
			// 	),
			);
		$this->config = array_merge($defaults,$config);
		if ($this->config["user_check"] != "ip_address" && $this->config["user_check"] != "kitteh_address")
			$this->config["user_check"] = "both";

		if ($this->config["captcha"] != "recaptcha" && $this->config["captcha"] != "simple-captcha")
			$this->config["captcha"] = "simple-captcha";

		// TODO: add config for different CAPTCHAs instead of having it hard coded here.
		if ($this->config["captcha"] == "recaptcha")
			require_once('./lib/recaptchalib.php');
		else
			{
			$this->config["captcha_config"]["session_name"] = "dgsfauc";
			require_once('./lib/simple-captcha/simple-php-captcha.php');
			}
		// ---

		if (isset($config["rpc_user"],$config["rpc_password"],$config["rpc_host"],$config["rpc_port"],$config["mysql_user"],$config["mysql_password"],$config["mysql_host"],$config["mysql_database"]))
			{
			if (class_exists("jsonRPCClient"))
				{
				$this->rpc_client = new jsonRPCClient('http://'.urlencode($config["rpc_user"]).':'.urlencode($config["rpc_password"]).'@'.urlencode($config["rpc_host"]).':'.urlencode($config["rpc_port"]));
				
				$this->db = @new mysqli($config["mysql_host"],$config["mysql_user"],$config["mysql_password"],$config["mysql_database"]);
				//if (!$this->db->connect_error)
				if (!mysqli_connect_error() && !is_null($this->balance = $this->rpc("getbalance"))) // compatibility with older PHP versions
					{
					$this->total_donated = $this->rpc("getreceivedbyaddress",array($this->config["donation_address"]));
					if ($this->balance >= $this->config["payout_threshold"])
						{
						$this->status = SF_STATUS_OPERATIONAL;
						if ($this->config["use_captcha"] && $this->config["captcha"] == "simple-captcha")
							{
							@session_name("dgsfauc");
							@session_start();
							//$_SESSION['captcha'] = simple_php_captcha($this->config["captcha_config"]);
							}

						if (isset($_POST["kittehcoin_address"]) && (($this->config["use_captcha"] && $this->valid_captcha()) || !$this->config["use_captcha"]))
							{
							$kittehcoin_address = $_POST["kittehcoin_address"];
							$validation = $this->rpc("validateaddress",array($kittehcoin_address));
							if ($validation["isvalid"])
								{
								$interval = "7 HOUR"; // hardcoded default interval if the custom interval is messed up
								$interval_value = intval(substr($this->config["payout_interval"],0,-1));
								$interval_function = strtoupper(substr($this->config["payout_interval"],-1));
								if ($interval_value >= 0 && ($interval_function == "H" || $interval_function == "M" || $interval_function == "D"))
									{
									$interval = $interval_value." ";
									switch ($interval_function)
										{
										case "M":
											$interval .= "MINUTE";
											break;
										case "H":
											$interval .= "HOUR";
											break;
										case "D":
											$interval .= "DAY";
											break;
										}
									}
									
									$ch = curl_init("https://www.dan.me.uk/torlist/");
									curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
									$text = curl_exec($ch);
									$test = strpos($text, $_SERVER["REMOTE_ADDR"]);
									if ($test==false)
									{
									
									
									
								$user_check = " AND (";
								if ($this->config["user_check"] == "ip_address" || $this->config["user_check"] == "both")
									$user_check .= " `ip_address` = '".$this->db->escape_string($_SERVER["REMOTE_ADDR"])."'";
								if ($this->config["user_check"] == "kitteh_address" || $this->config["user_check"] == "both")
									$user_check .= ($this->config["user_check"] == "both"?" OR":"")." `payout_address` = '".$this->db->escape_string($kittehcoin_address)."'";
								$user_check .= ")";
								$result = $this->db->query("SELECT `id` FROM `".$this->db->escape_string($this->config["mysql_table_prefix"])."payouts` WHERE `timestamp` > NOW() - INTERVAL ".$interval.$user_check);
								if ($row = $result->fetch_assoc())
									$this->status = SF_STATUS_PAYOUT_DENIED; // user already received a payout within the payout interval
								else
									{
									$this->payout_amount = mt_rand($this->config["minimum_payout"]*10000,$this->config["maximum_payout"]*10000)/10000; // calculate a random MEOW amount
									$this->db->query("INSERT INTO `".$this->db->escape_string($this->config["mysql_table_prefix"])."payouts` (`payout_amount`,`ip_address`,`payout_address`,`timestamp`) VALUES ('".$this->payout_amount."','".$this->db->escape_string($_SERVER["REMOTE_ADDR"])."','".$this->db->escape_string($kittehcoin_address)."',NOW())"); // insert the transaction into the payout log
									if ($this->config["wallet_passphrase"] != "")
										$this->rpc("walletpassphrase",array($this->config["wallet_passphrase"],4)); // unlock wallet
									$this->status = !is_null($this->rpc("sendtoaddress",array($kittehcoin_address,$this->payout_amount))) ? SF_STATUS_PAYOUT_ACCEPTED : SF_STATUS_PAYOUT_ERROR; // send the MEOW
									if ($this->config["wallet_passphrase"] != "")
										$this->rpc("walletlock"); // lock wallet
									}
									
									
									}
									else
									{
										$this->status = SF_STATUS_BANNED_IP;
									}
								}
							else
								$this->status = SF_STATUS_INVALID_KITTEH_ADDRESS;
							}
						else
							{
							if ($this->config["use_captcha"] && $this->config["captcha"] == "simple-captcha")
								$_SESSION['captcha'] = simple_php_captcha($this->config["captcha_config"]); // set a new CAPTCHA
							if (isset($_POST["kittehcoin_address"]))
								$this->status = SF_STATUS_CAPTCHA_INCORRECT;
							}
						}
					else
						$this->status = SF_STATUS_DRY_FAUCET;
					}
				else
					$this->status = SF_STATUS_MYSQL_CONNECTION_FAILED;
				}
			else
				$this->status = SF_STATUS_FAUCET_INCOMPLETE; // missing RPC client
			}
		else
			$this->status = SF_STATUS_FAUCET_INCOMPLETE; // missing some settings
		}

	public function render()
		{
		if (!file_exists("./templates/".$this->config["template"].".template.php"))
			die("Template ".$this->config["template"]."not found.");
		ob_start();
		include("./templates/".$this->config["template"].".template.php");
		$template = ob_get_clean();
		
		
		
		
		$self = $this;
		$config = $this->config;
		$balance = $this->balance;
		$total_donated = $this->total_donated;
		$payout_amount = $this->payout_amount;
		$payout_address = $this->payout_address;

		$template = preg_replace_callback("/\{\{([a-zA-Z-0-9\ \_]+?)\}\}/",function($match) use ($self,$config,$balance,$payout_amount,$payout_address,$total_donated)
			{
			switch (strtolower($match[1]))
				{
				// faucet information:
				case "minimum_payout":
				case "maximum_payout":
				case "payout_threshold":
				case "donation_address":
				case "title":
					return isset($config[strtolower($match[1])]) ? $config[strtolower($match[1])] : $match[1];

				case "balance":
					return $balance;
				
				// statistics:
				case "average_payout":
					return $self->payout_aggregate("AVG");

				case "total_payout":
				case "total_payouts":
					return $self->payout_aggregate("SUM");

				case "smallest_payout":
					return $self->payout_aggregate("MIN");

				case "largest_payout":
					return $self->payout_aggregate("MAX");

				case "number_of_payouts":
					return $self->payout_aggregate("COUNT");
					
				case "total_donated":
					return $total_donated;

				// current user information:
				case "payout_amount":
					return $payout_amount;

				case "payout_address":
					return $payout_address;

				// CAPTCHA:

				case "captcha":
					if ($config["captcha"] == "recaptcha")
						return recaptcha_get_html(@$config["captcha_config"]["public_key"]);
					return isset($_SESSION['captcha']) ? '<img src="'.$_SESSION['captcha']["image_src"].'" alt="[captcha]"/>' : '';
					//return isset($_SESSION['captcha']) ? '<img src="'.htmlentities($_SESSION['captcha']["image_src"]).'" alt="[captcha]"/>' : '';

				case "captcha_url":
					return isset($_SESSION['captcha']) ? $_SESSION['captcha']["image_src"] : '';

				default:
					return $match[1];
				}
			},$template);
		echo $template;
		}

	public function status()
		{
		return $this->status;
		}

	// Payout aggregate functions, to make things easier.
	// Possible functions are:
	// AVG - average payout
	// SUM - total payout
	// MIN - smallest payout
	// MAX - largest payout
	// COUNT - number of payouts
	// See: http://dev.mysql.com/doc/refman/5.0/en/group-by-functions.html
	// TODO- add datetime periods.
	public function payout_aggregate($function = "AVG")
		{
		//if ($this->db->ping())
		if ($this->status != SF_STATUS_MYSQL_CONNECTION_FAILED)
			{
			if ($result = $this->db->query("SELECT ".$this->db->escape_string($function)."(`payout_amount`) FROM `".$this->db->escape_string($this->config["mysql_table_prefix"])."payouts`"))
				{
				$row = $result->fetch_array(MYSQLI_NUM);
				return is_float($row[0]) ? number_format($row[0],6) : $row[0];
				}
			}
		return false;
		}

	protected function valid_captcha()
		{
		if ($this->config["captcha"] == "recaptcha")
			{
			$resp = @recaptcha_check_answer($this->config["captcha_config"]["private_key"],$_SERVER["REMOTE_ADDR"],@$_POST["recaptcha_challenge_field"],@$_POST["recaptcha_response_field"]);
			return $resp->is_valid; // $resp->error;
			}
		return @$_POST["captcha_code"] == @$_SESSION['captcha']['code'];		
		}

	protected function rpc($method,$params = array())
		{
		try
			{
			return @$this->rpc_client->__call($method,$params);
			}
		catch (Exception $e)
			{
			$this->status = SF_STATUS_RPC_CONNECTION_FAILED;
			return null;
			}
		}
	}

defined("SIMPLE_FAUCET") || header(".");
?>