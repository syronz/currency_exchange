<?php
	require_once 'class/database.class.php';
	require_once 'class/order_payout.class.php';
	$order_payout_info = order_payout::get_order_payout_info(@$_GET['id']);
	// dsh($order_payout_info);

	$money = '';
	if($order_payout_info['a_dollar'])
		$money .= dsh_money($order_payout_info['a_dollar']).' دۆلار ';
	// if($order_payout_info['a_dinar'])
	// 	$money .= dsh_money($order_payout_info['a_dinar']).' دینار | ';
	// if($order_payout_info['a_tman'])
	// 	$money .= dsh_money($order_payout_info['a_tman']).' تمەن ';
?>
<html>
<?php require_once 'head_tag.php'; ?>
  <body>
  	<style>
@font-face{
    font-family: 'kxani';
    src: url(themes/kxani.woff);
}
.corner{
    margin-top: -55px;
    /*position: absolute;*/
    float: right;
    font-family: arial;
    font-size: smaller;
    direction: rtl;
}
section{
    direction: rtl;
    font-family: 'kxani';
}
section h2, section h3{
    text-align: center;
    margin:0;
}
.corner p{
    margin:0 25px 5px 0;
}
section p{
    margin:0 15px 2px 0;
    padding: 5px;
    padding-right: 15px;
    border-radius: 3px;
}
section p span{
    display: inline-block;
    width: 100px;
}
section .package{
    border: 2px solid gray;
    border-radius: 5px;
    padding: 10px;
    margin-top: 10px;
}
.pedar{
    float:right;
    margin: 25px 150px 0 0;
	text-align:center;
}
.warger{
    float:left;
    margin: 25px 0 0 150px;
	text-align:center;
}
.clear{
    clear:both;
}
.ee{
    background-color: #EEE;
}
.dash{
    border-bottom: 1px dotted gray;
    margin: 40px 0 10px 0;
    text-align: center;
    font-family: courier new;
    font-size: 7px;
}
.dash2{
    margin: 20px 0 0 0;
    text-align: center;
    font-family: courier;
    font-size: 7px;
}
  		
  	</style>
  	<div id="wrapper">
  		<?php require_once 'nav.php'; ?>
  		<div id="main">

  		<table border="1" style="width:100%; direction:ltr;" >
  			<tr>
  				<td>
  					<h2>VALAN Company</h2>
					<h3>For General Trade / Ltd.</h3>
				</td>
  				<td style="direction:rtl;">
  					<h2>کۆمپانیای ڤالان</h2>
					<h3>بۆ بازرگانی گشتی سنوردار</h3>
				</td>
				
  			</tr>
  			<tr>
  				<td>
  					بەروار : <?php echo $order_payout_info['date_time']; ?>
				</td>
  				<td>
  					ژمارە پسوله : <?php echo $order_payout_info['id']; ?>
				</td>
  			</tr>
  			<tr>
  				<td>
  					get from
				</td>
  				<td>
  					pay to
				</td>
  			</tr>
  			<tr>
  				<td colspan="2">
  					money
				</td>
  			</tr>
  			<tr>
  				<td colspan="2">
  					money word
				</td>
  			</tr>
  			<tr>
  				<td colspan="2">
  					detail
				</td>
  			</tr>
  			<tr></tr>
  		</table>
			<section>
				
				
				
				<hr>
				<h3>وەرگرتنی پاره</h3>
				<div class="package">
					<p><span> بری پاره  </span>: <?php echo $money ?> </p>
					<p class="ee"><span> تەنها </span>: <?php echo money_to_word(intval($order_payout_info['a_dollar'])); ?> دۆلار </p>
					<!-- <p class="ee"><span> ناوی نێردەر </span>: <?php echo $order_payout_info['sender_name']; ?></p>
					<p><span> تەلەفونی نێردەر </span>: <?php echo $order_payout_info['sender_phone']; ?></p> -->
					<p><span> ناوی وەرگر </span>: <?php echo $order_payout_info['reciever_name']; ?></p>
					<!-- <p class="ee"><span> تەلەفونی وەرگر </span>: <?php echo $order_payout_info['reciever_phone']; ?></p> -->
					<!-- <p class="ee"><span> ناونیشانی وەرگر </span>: <?php echo $order_payout_info['reciever_address']; ?></p> -->
					<p class="ee"><span> تێبینی </span>: <?php echo $order_payout_info['detail']; ?></p>
				</div>
				<div class="pedar">پێدەر <br><br> ژم:07701551035</div>
				<div class="warger">وەرگر <br><br>  ژم: <?php echo $order_payout_info['reciever_phone']; ?></div>
				<div class="clear"></div>
			</section><br><br><br>
			<div class="dash">Produced By PointSoft Company [07503273839]</div>
			<br><br><br>
			<section>
				<h2>کۆمپانیای ڤالان</h2>
				<h3>بۆ بازرگانی گشتی سنوردار</h3>
				
				<div class="corner">
					<p>بەروار : <?php echo $order_payout_info['date_time']; ?></p>
					<p>ژمارە پسوله : <?php echo $order_payout_info['id']; ?></p>
				</div>
				<hr>
				<h3>وەرگرتنی پاره</h3>
				<div class="package">
					<p><span> بری پاره  </span>: <?php echo $money ?> </p>
					<p class="ee"><span> تەنها </span>: <?php echo money_to_word(intval($order_payout_info['a_dollar'])); ?> دۆلار </p>
					<!-- <p class="ee"><span> ناوی نێردەر </span>: <?php echo $order_payout_info['sender_name']; ?></p>
					<p><span> تەلەفونی نێردەر </span>: <?php echo $order_payout_info['sender_phone']; ?></p> -->
					<p><span> ناوی وەرگر </span>: <?php echo $order_payout_info['reciever_name']; ?></p>
					<!-- <p class="ee"><span> تەلەفونی وەرگر </span>: <?php echo $order_payout_info['reciever_phone']; ?></p> -->
					<!-- <p class="ee"><span> ناونیشانی وەرگر </span>: <?php echo $order_payout_info['reciever_address']; ?></p> -->
					<p class="ee"><span> تێبینی </span>: <?php echo $order_payout_info['detail']; ?></p>
				</div>
				<div class="pedar">پێدەر <br><br> ژم:07701551035</div>
				<div class="warger">وەرگر <br><br>  ژم: <?php echo $order_payout_info['reciever_phone']; ?></div>
				<div class="clear"></div>
			</section>
			<div class="dash2">Produced By PointSoft Company [07503273839]</div>
		</div>
		<?php require_once 'footer.php'; ?>
	</div>

 
  </body>
</html>
