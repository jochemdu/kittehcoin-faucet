<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
	<meta name="author" content="Jonathan Heald" />
	<link rel="stylesheet" href="./css/default.css" type="text/css" />
	<title>{{TITLE}}</title>
</head>
<body>
	<div id="wrapper">
		<h1>{{TITLE}}</h1>
		<div class="container">
			<?php 
			switch ($this->status())
				{
				case SF_STATUS_FAUCET_INCOMPLETE:
					?>
					<p>This faucet is incomplete, it may be missing settings or the RPC client is not available.</p>
					<?php
					break;

				case SF_STATUS_DRY_FAUCET:
					?>
					<p>NO MORE CATNIP! Please donate.</p>
					<?php
					break;

				case SF_STATUS_RPC_CONNECTION_FAILED:
				case SF_STATUS_MYSQL_CONNECTION_FAILED:
					?>
					<p>Cannot seem to connect at the moment, Waiting for human to come back!</p>
					<?php
					break;
				
				case SF_STATUS_PAYOUT_ACCEPTED:
					?>
					<p>Success! You have been awarded with {{PAYOUT_AMOUNT}} MEOW! come back in 4 hours for more :-)</p>
					<?php
					break;

				case SF_STATUS_PAYOUT_ERROR:
					?>
					<p>Something went wrong, could not send you MEOW... Please try again later.</p>
					<?php
					break;

				case SF_STATUS_PAYOUT_DENIED:
					?>
					<p>GREEDY KITTY! Wait longer then try again later.</p>
					<?php
					break;

				case SF_STATUS_CAPTCHA_INCORRECT:
				case SF_STATUS_INVALID_KITTEH_ADDRESS:
				case SF_STATUS_OPERATIONAL:
					?>
					
					<form method="post" action="">
						<input name="kittehcoin_address" type="text" value="" placeholder="Enter your Kitteh address here" />
						{{CAPTCHA}}
						<input name="captcha_code" type="text" value="" placeholder="Enter the code you see above" />
						<input name="kittehcoin_submit" type="submit" value="Get coins" />
					</form>
					<?php
					if ($this->status() == SF_STATUS_INVALID_KITTEH_ADDRESS)
						{
						?>
						<p class="error">You entered an invalid Kitteh address!</p>
						<?php
						}
					elseif ($this->status() == SF_STATUS_CAPTCHA_INCORRECT)
						{
						?>
						<p class="error">The CAPTCHA code you entered was incorrect!</p>
						<?php
						}
					break;

				
				}
			?>
		</div>
		<div class="container">
			<p>Please donate to keep this faucet running:</p>
			<p class="big">{{DONATION_ADDRESS}}</p>
		</div>
		<div id="stats">
			<p>Faucet balance: {{BALANCE}}</p>
			<p>Average payout: {{AVERAGE_PAYOUT}}</p>
			<p>{{NUMBER_OF_PAYOUTS}} payouts</p>
			<p>{{TOTAL_DONATED}} Donated</p>
			
			<iframe data-aa='9205' src='//ad.a-ads.com/9205?size=468x60' scrolling='no' style='width:468px; height:60px; border:0px; padding:0;overflow:hidden' allowtransparency='true'></iframe>
		</div>
		<img src="./images/kittehcoin.png" class="kittehcoin" alt=""/>
		<img src="./images/kittehcoin.png" class="kittehcoin" alt=""/>
		<img src="./images/kittehcoin.png" class="kittehcoin" alt=""/>
	</div>
</body>
</html>