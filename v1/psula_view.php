<?php
	require_once 'class/database.class.php';
	require_once 'class/order_payment.class.php';
	$order_payment_info = order_payment::get_psula_payment_info(@$_GET['id']);
	// dsh($order_payment_info);

	switch ($order_payment_info['type']) {
		case 'dollar':
			$symbol = '$';
			break;
		case 'tman':
			$symbol = 'IRR';
			break;
		case 'dinar':
			$symbol = 'IQD';
			break;
		case 'euro':
			$symbol = '€';
			break;
		
		default:
			$symbol = '';
			break;
	}

	$money = '';
	if($order_payment_info['amount'])
		$money .= dsh_money($order_payment_info['amount']).' '.$symbol;
	

	// dsh($order_payment_info['a_dollar']);
	// dsh(money_to_word(1660000000));
	// dsh($order_payment_info['a_dollar']);
	// dsh(money_to_word(intval($order_payment_info['a_dollar'])));
?>
<html>
<?php require_once 'head_tag.php'; ?>
  <body>
  	<style>
@font-face{
    font-family: 'kxani';
    src: url(themes/kxani.woff);
}
@font-face{
    font-family: 'KChimen';
    src: url(themes/KChimen.ttf);
}

/*****************************************/


.dash{
    /*border-bottom: 1px dotted gray;*/
    margin: 40px 0 10px 0;
    text-align: center;
    font-family: courier new;
    font-size: 7px;
}


  		
  	</style>
  	<div id="wrapper">
  		<?php require_once 'nav.php'; ?>
  		<div id="main">
  		
  		<table border="0" cellspacing="0" cellpadding="0" style="width:100%; direction:ltr;font-family: 'kxani';" >
  			<tr>
  				<td style="width:33%;">
  					VALAN Company
				</td>
				<td rowspan="2"  style="width:33%;text-align:center;font-size:18px;">پسوڵەی پارە وەرگرتن</td>
  				<td style="direction:rtl;font-family:'KChimen';width:33%;">
  					کۆمپانیای ڤالان
				</td>
				
  			</tr>
  			<tr>
  				<td style="width:33%;font-size:smaller;">
					For General Trade / Ltd.
				</td>
				
  				<td style="direction:rtl;font-family:'KChimen';font-size:smaller">
					بۆ بازرگانی گشتی سنوردار
				</td>
  			</tr>
  			
		</table>
		<table border="0" cellspacing="0" cellpadding="0" style="width:100%; direction:ltr;margin-top:10px;font-family: 'kxani';border: 1px solid #d6dbdd; " >
  			<tbody>
  			
  			<tr style="direction:ltr; background-color:#d6dbdd;font-family: arial;font-family:times new roman;font-style: italic;font-size: 12px;">
  				<td style="padding:12px;width:50%;">
  					ژمارە پسوله : <?php echo $order_payment_info['id']; ?>
				</td>
  				<td style="text-align:right;direction:ltr; padding:12px;font-family:times new roman;font-style: italic;font-size: 12px;">
  					<?php echo $order_payment_info['date_time']; ?>
				</td>
  				
  			</tr>
  			<tr style="direction:rtl;color:gray;font-family:'KChimen';font-size:12px; padding-top:8px;">
  				<td style="padding-top:8px;">
  					لە بری حەواڵە بۆ
				</td>
  				<td style="padding-top:8px;padding-right:19px;">
  					وەرگیراوە لە
				</td>
  				
  			</tr>
  			<tr style="direction:rtl;border-bottom: 1px solid #d6dbdd;padding-bottom:10px;">
  				<td style="direction:rtl;border-bottom: 1px solid #d6dbdd;padding-bottom:10px;vertical-align: top;">
  					<?php echo str_replace("\n", "<br>", $order_payment_info['reciever']); ?>
				</td>
  				<td style="direction:rtl;border-bottom: 1px solid #d6dbdd;padding-bottom:10px;padding-right:19px;vertical-align: top;">
  					<?php echo str_replace("\n", "<br>",$order_payment_info['sender']); ?>
				</td>
  			</tr>
  			<tr>
  				<td colspan="2" style="padding-top:8px;direction:rtl;color:gray;padding-right:19px;font-family:'KChimen';font-size:12px;">
  					<span> بڕی پاره  </span>
				</td>
  			</tr>
  			<tr>
  				<td colspan="2" style="direction:rtl;font-family:Calibri;font-size:28px;padding-right:19px;color:maroon;">
  					<?php echo $money ?> 
				</td>
  			</tr>
  			<tr>
  				<td colspan="2" style="direction:rtl;border-bottom: 1px solid #d6dbdd;padding-bottom:10px;direction:rtl;padding-right:19px; font-size:18px;">
  					<?php echo money_to_word(intval($order_payment_info['amount']));
  						  echo ' '.dic_return($order_payment_info['type']);
  					 ?> 
				</td>
  			</tr>
  			<tr>
  				<td colspan="2" style="padding-top:8px;direction:rtl;color:gray;padding-right:19px;font-family:'KChimen';font-size:12px;">
  					<span> تێبینی </span>
				</td>
  			</tr>
  			<tr>
  				<td colspan="2" style="direction:rtl;border-bottom: 1px solid #d6dbdd;padding-bottom:10px;direction:rtl;padding-right:19px;">
  					<?php echo $order_payment_info['detail']; ?>
				</td>
  			</tr>
  			</tbody>
  			</table>

<table border="0" cellspacing="0" cellpadding="0" style="width:100%; direction:ltr;font-family: 'kxani';border:1px solid #d6dbdd;">
  			<tr>
  				<td style="padding-top:8px;width:50%;color:gray;direction:rtl;font-family:'KChimen';font-size:12px;">
  				<p>تەلەفون</p>
  				</td>
  				<td style="padding-top:8px;color:gray;direction:rtl;padding-right:19px;font-family:'KChimen';font-size:12px;">
  				<p>ناونیشان</p>
  				</td>
  				
  			</tr>
  			<tr>
  				<td class="" style="text-align:right;font-family:times new roman;font-style: italic;font-size: 12px;">
  				053 326 2929 / 0770 155 1035 / 0770 157 0693
  				</td>
  				<td style="direction:rtl;padding-right:19px;">
  				بازاری شەوکەتی مەلا، نهۆمی ژێرزەمین
  				</td>
  			</tr>
  			<tr>
  				<td colspan="2" class="dash" style="background-color:#323331;border:1 px solid #323331; color:white;">
  				Produced By PointSoft Company [07503273839]
  				</td>
  			</tr>
  		</table>

  			<table border="0" cellspacing="0" cellpadding="0" style="margin-top:10px;width:100%; direction:ltr;font-family: 'kxani';">
  			<tr>
  				<td style="text-align:center;padding:5px;font-family:'KChimen';font-size:12px;width:50%;">
  					واژو
				</td>
  				<td style="text-align:center;padding:5px;">
  					
				</td>
  			</tr>
  			<tr></tr>
  		</table>










<p style="border-top: dotted 1px #EEE;margin:5px 0;"></p>

















  		<table border="0" cellspacing="0" cellpadding="0" style="width:100%; direction:ltr;font-family: 'kxani';" >
  			<tr>
  				<td style="width:33%;">
  					VALAN Company
				</td>
				<td rowspan="2"  style="width:33%;text-align:center;font-size:18px;">پسوڵەی پارە وەرگرتن</td>
  				<td style="direction:rtl;font-family:'KChimen';width:33%;">
  					کۆمپانیای ڤالان
				</td>
				
  			</tr>
  			<tr>
  				<td style="width:33%;font-size:smaller;">
					For General Trade / Ltd.
				</td>
				
  				<td style="direction:rtl;font-family:'KChimen';font-size:smaller">
					بۆ بازرگانی گشتی سنوردار
				</td>
  			</tr>
  			
		</table>
		<table border="0" cellspacing="0" cellpadding="0" style="width:100%; direction:ltr;margin-top:10px;font-family: 'kxani';border: 1px solid #d6dbdd; " >
  			<tbody>
  			
  			<tr style="direction:ltr; background-color:#d6dbdd;font-family: arial;font-family:times new roman;font-style: italic;font-size: 12px;">
  				<td style="padding:12px;width:50%;">
  					ژمارە پسوله : <?php echo $order_payment_info['id']; ?>
				</td>
  				<td style="text-align:right;direction:ltr; padding:12px;font-family:times new roman;font-style: italic;font-size: 12px;">
  					<?php echo $order_payment_info['date_time']; ?>
				</td>
  				
  			</tr>
  			<tr style="direction:rtl;color:gray;font-family:'KChimen';font-size:12px; padding-top:8px;">
  				<td style="padding-top:8px;">
  					لە بری حەواڵە بۆ
				</td>
  				<td style="padding-top:8px;padding-right:19px;">
  					وەرگیراوە لە
				</td>
  				
  			</tr>
  			<tr style="direction:rtl;border-bottom: 1px solid #d6dbdd;padding-bottom:10px;">
  				<td style="direction:rtl;border-bottom: 1px solid #d6dbdd;padding-bottom:10px;vertical-align: top;">
  					<?php echo str_replace("\n", "<br>", $order_payment_info['reciever']); ?>
				</td>
  				<td style="direction:rtl;border-bottom: 1px solid #d6dbdd;padding-bottom:10px;padding-right:19px;vertical-align: top;">
  					<?php echo str_replace("\n", "<br>",$order_payment_info['sender']); ?>
				</td>
  			</tr>
  			<tr>
  				<td colspan="2" style="padding-top:8px;direction:rtl;color:gray;padding-right:19px;font-family:'KChimen';font-size:12px;">
  					<span> بڕی پاره  </span>
				</td>
  			</tr>
  			<tr>
  				<td colspan="2" style="direction:rtl;font-family:Calibri;font-size:28px;padding-right:19px;color:maroon;">
  					<?php echo $money ?> 
				</td>
  			</tr>
  			<tr>
  				<td colspan="2" style="direction:rtl;border-bottom: 1px solid #d6dbdd;padding-bottom:10px;direction:rtl;padding-right:19px; font-size:18px;">
  					<?php echo money_to_word(intval($order_payment_info['amount']));
  						  echo ' '.dic_return($order_payment_info['type']);
  					 ?> 
				</td>
  			</tr>
  			<tr>
  				<td colspan="2" style="padding-top:8px;direction:rtl;color:gray;padding-right:19px;font-family:'KChimen';font-size:12px;">
  					<span> تێبینی </span>
				</td>
  			</tr>
  			<tr>
  				<td colspan="2" style="direction:rtl;border-bottom: 1px solid #d6dbdd;padding-bottom:10px;direction:rtl;padding-right:19px;">
  					<?php echo $order_payment_info['detail']; ?>
				</td>
  			</tr>
  			</tbody>
  			</table>

<table border="0" cellspacing="0" cellpadding="0" style="width:100%; direction:ltr;font-family: 'kxani';border:1px solid #d6dbdd;">
  			<tr>
  				<td style="padding-top:8px;width:50%;color:gray;direction:rtl;font-family:'KChimen';font-size:12px;">
  				<p>تەلەفون</p>
  				</td>
  				<td style="padding-top:8px;color:gray;direction:rtl;padding-right:19px;font-family:'KChimen';font-size:12px;">
  				<p>ناونیشان</p>
  				</td>
  				
  			</tr>
  			<tr>
  				<td class="" style="text-align:right;font-family:times new roman;font-style: italic;font-size: 12px;">
  				053 326 2929 / 0770 155 1035 / 0770 157 0693
  				</td>
  				<td style="direction:rtl;padding-right:19px;">
  				بازاری شەوکەتی مەلا، نهۆمی ژێرزەمین
  				</td>
  			</tr>
  			<tr>
  				<td colspan="2" class="dash" style="background-color:#323331;border:1 px solid #323331; color:white;">
  				Produced By PointSoft Company [07503273839]
  				</td>
  			</tr>
  		</table>

  			<table border="0" cellspacing="0" cellpadding="0" style="margin-top:10px;width:100%; direction:ltr;font-family: 'kxani';">
  			<tr>
  				<td style="text-align:center;padding:5px;font-family:'KChimen';font-size:12px;width:50%;">
  					واژو
				</td>
  				<td style="text-align:center;padding:5px;">
  					
				</td>
  			</tr>
  			<tr></tr>
  		</table>
  		
			</div>
		<?php require_once 'footer.php'; ?>
	</div>

 
  </body>
</html>
