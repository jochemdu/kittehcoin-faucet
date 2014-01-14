<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>KittehCoin Catnip Faucet</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/jumbotron.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

  <!--  <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
       <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Project name</a>
        </div>
        <div class="navbar-collapse collapse">

        </div>
      </div>
    </div> -->

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
    	
    	<center>
    	<iframe data-aa='9205' src='//ad.a-ads.com/9205?size=468x60' scrolling='no' style='width:468px; height:60px; border:0px; padding:0;overflow:hidden' allowtransparency='true'></iframe>
    	<p>
    	<a href="http://1url.co.uk/catnip"><img src="./images/logo.png" alt=""/></a>
    	<P>
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
					<p>Success! You have been awarded with {{PAYOUT_AMOUNT}} MEOW! <br /> come back in 4 hours for more :-)</p>
					<p><img src="images/good.jpg" class="img-rounded"></p>
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
					<P />
						<input name="kittehcoin_address" class="input-xxlarge" type="text" placeholder="Enter your Kitteh address here" style="width:468px;" >
						<P />
						{{CAPTCHA}}
						<P />
						<P />
						<input name="kittehcoin_submit" type="submit" value="Get coins" class="btn btn-primary btn-lg" />
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
					elseif ($this->status() == SF_STATUS_BANNED_IP)
						{
						?>
						<p class="error">This IP has been banned! If you are using a proxy please try again after disabling your proxy.</p>
						<?php
						}
					break;

				
				}
			?>
			
			<div class="container">
			<p><b>Please donate to keep this faucet running:</p>
			<p class="big">{{DONATION_ADDRESS}}</p></b>
		</div>
		<div id="stats">
			
			
			<iframe data-aa='9205' src='//ad.a-ads.com/9205?size=468x60' scrolling='no' style='width:468px; height:60px; border:0px; padding:0;overflow:hidden' allowtransparency='true'></iframe>
		</div>
</center>
      </div>
    </div>

    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-4">
          <h2>Want to Donate?</h2>
          <p>This faucet is funded by me, as well as generous users like you. Please donate anything you can.</p>
          <p><b>{{DONATION_ADDRESS}}</b></p>
        </div>
        <div class="col-md-4">
          <h2>Help the community</h2>
          <p>want to learn more about KittehCoin and contribute? </p>
          <p><a class="btn btn-default" href="http://kittehcoin.info" target="_BLANK" role="button">Check it out &raquo;</a></p>
       </div>
        <div class="col-md-4">
          <h2>Stats</h2>
         	<p><span class="label label-info">Faucet balance:</span> {{BALANCE}}</p>
			<p><span class="label label-info">Average payout:</span> {{AVERAGE_PAYOUT}}</p>
			<p><span class="label label-info">Payouts:</span> {{NUMBER_OF_PAYOUTS}}</p>
			<p><span class="label label-info">Total Donated:</span> {{TOTAL_DONATED}}</p>
           </div>
      </div>

      <hr>

      <footer>
        <center><iframe data-aa='9205' src='//ad.a-ads.com/9205?size=468x60' scrolling='no' style='width:468px; height:60px; border:0px; padding:0;overflow:hidden' allowtransparency='true'></iframe><iframe data-aa='9205' src='//ad.a-ads.com/9205?size=468x60' scrolling='no' style='width:468px; height:60px; border:0px; padding:0;overflow:hidden' allowtransparency='true'></iframe></center>
      </footer>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    
<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_floating_style addthis_counter_style" style="left:50px;top:50px;">
<a class="addthis_button_facebook_like" fb:like:layout="box_count"></a>
<a class="addthis_button_tweet" tw:count="vertical"></a>
<a class="addthis_button_google_plusone" g:plusone:size="tall"></a>
<a class="addthis_counter"></a>
</div>
<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=jonn4y"></script>
<!-- AddThis Button END -->

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-817613-11']);
  _gaq.push(['_setDomainName', '1url.co.uk']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

  </body>
</html>
