<?php
require_once 'class/database.class.php';


  // dsh(date('Y-m-d H:i:s',time()));
?>
<html>
<?php require_once 'head_tag.php'; ?>
	<style>
  		h2{
  			text-align: center;
  			font-family: arial;
  			color: #000066;
  		}
  		#big_img{
  			margin: 0 auto;
  		}
  		div p{
  			width: 128px;
  			/*float: left;
  			border: 1px solid red;*/
  			display: inline-block;
  			margin: 5px 5px 25px 5px;
  			padding: 5px;
  			border-radius: 5px;
  		}
  		div p:hover{
  			background-color: rgba(255,102,0,0.1);
  		}
  		div p a{
  			text-decoration: none;
  			font-family: tahoma;
  			color: gray;
  			/*font-size: 13px;*/
  		}
  		div p a span:hover{
  			margin-top: -6px;
  			
  		}

  		div p a img{
  			width: 100px;
  			border: none;
  		}
  		.clear{
  			clear:both;
  		}
  	</style>

  <body>

  	<div id="wrapper">
  		<?php  require_once 'nav.php'; ?>
  		<!-- <div class="navigation">
  			<a href="index.php" ><button id="index"><?php dic_show('Main'); ?></button></a>
  			<a href="accounts.php" ><button id="accounts"><?php dic_show('Accounts'); ?></button></a>
  			<a href="payments.php" ><button id="paymnets"><?php dic_show('Payments'); ?></button></a>
  			<a href="payouts.php" ><button id="payouts"><?php dic_show('Payouts'); ?></button></a>
  			<a href="reports.php?year=2013" ><button id="reports"><?php dic_show('Reports'); ?></button></a>
  			<a href="user_activity.php" ><button id="user_activity"><?php dic_show('Activity'); ?></button></a>
  			<a href="help.php" ><button id="help"><?php dic_show('Help'); ?></button></a>
  		</div> -->
		<div class="center" id="main">
			<!-- <h2><?php dic_show('VALAN Company'); ?></h2> -->
			<img src="images/currency-exchange.png" id="big_img">
			<br>
			<br>
      
			<p>
				<a href="logout.php">
					<img src="images/logout.png">
						
					<span><?php dic_show('Logout'); ?></span>
				</a>
			</p>
			<p>
				<a href="about.php">
					<img src="images/logo2.png">
						<br>
					<span><?php dic_show('Point Company'); ?></span>
				</a>
			</p>
			<p>
				<a href="news.php">
					<img src="images/news.png">
					<span><?php dic_show('news'); ?></span>
				</a>
			</p>
			
			<p>
				<a href="report_selection.php?year=2013">
					<img src="images/reports.png">
					<span><?php dic_show('Reports'); ?></span>
				</a>
			</p>
			<p>
				<a href="user_activity.php?year=2013">
					<img src="images/user_activity.png">
					<span><?php dic_show('Activity'); ?></span>
				</a>
			</p>
			<p>
				<a href="fund.php">
					<img src="images/payouts.png">
					<span><?php dic_show('All Fund'); ?></span>
				</a>
			</p>
			<p>
				<a href="buy_sell.php">
					<img src="images/buy_sell.png">
					<span><?php dic_show('All Buy & Sell'); ?></span>
				</a>
			</p>
			<p>
				<a href="backup.php">
					<img src="images/backup.png">
					<span><?php dic_show('Backup'); ?></span>
				</a>
			</p>
		</div>


  <?php require_once 'footer.php'; ?>
  </body>
</html>
