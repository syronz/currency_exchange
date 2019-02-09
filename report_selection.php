<?php
	require_once 'class/database.class.php';
	require_once 'class/order_payout.class.php';
	require_once 'class/accounts.class.php';
	$order_payout_info = order_payout::get_order_payout_info(@$_GET['id']);
	// dsh($order_payout_info);

	$money = '';
	if($order_payout_info['a_dollar'])
		$money .= dsh_money($order_payout_info['a_dollar']).' دۆلار | ';
	if($order_payout_info['a_dinar'])
		$money .= dsh_money($order_payout_info['a_dinar']).' دینار | ';
	if($order_payout_info['a_tman'])
		$money .= dsh_money($order_payout_info['a_tman']).' تمەن ';
?>
<html>
<?php require_once 'head_tag.php'; ?>
  <body>
  	<style>

  		
  	</style>
  	<div id="wrapper">
  		<?php require_once 'nav.php'; ?>
  		<div id="main">
			<article style="direction:rtl; margin:30px; text-align:center;">
				<p><input type="date" id="selected_date" value="<?php echo date('Y-m-d',time()); ?>"></p>
				<p><button id="show_fund_daily"><?php dic_show('Show Fund Daily'); ?></button></p>
				<p><button id="show_account_balance"><?php dic_show('Show Account Balance'); ?></button></p>
				<hr>
				<p>لە 
					<input type="date" id="start_date"> 
					تا 
					<input type="date" id="end_date" value="<?php echo date('Y-m-d',time()); ?>">		
					 / ئەکاونتی
					 <select id="id_account">
					 <?php
					 	$list_accounts = accounts::json_list(0);
					 	// dsh(json_decode($list_accounts));
					 	$json_list = json_decode($list_accounts);
					 	foreach ($json_list->Options as $key => $value) {
					 		echo "<option value='{$value->Value}'>{$value->DisplayText}</option>";
					 	}

					 ?>
					 </select>
					<button id="show_account_report_date"><?php dic_show('Show Account Transiction'); ?></button>
				</p>

			</article>

		</div>
		<?php require_once 'footer.php'; ?>
	</div>

	<script type="text/javascript">
		$('#show_fund_daily').click(function(){
			var selected_date = $('#selected_date').val();
			window.location.href = 'fund_daily.php?date='+selected_date;
		});
		$('#show_account_balance').click(function(){
			var selected_date = $('#selected_date').val();
			window.location.href = 'accounts_report.php?date='+selected_date;
		});
		$('#show_account_report_date').click(function(){
			var start_date = $('#start_date').val();
			var end_date = $('#end_date').val();
			var id_account = $('#id_account').val();
			window.location.href = 'accounts_report_date.php?start_date='+start_date+'&end_date='+end_date+'&id_account='+id_account;
		});
	</script>
  </body>
</html>
