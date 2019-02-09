<?php
	require_once 'class/database.class.php';
?>
<html>
<?php require_once 'head_tag.php'; ?>
  <body>
	<style>
		#Edit-id_account_buy, #Edit-id_account_sell{
			width: 146px;
		}
	</style>
  	<div id="wrapper">
  		<?php require_once 'nav.php'; ?>
  		<div id="main">
			<div id="new_buy_sell">
				
			</div>
			<div id="jtable_div" style="width: 1300px;"></div>
		</div>
		<?php require_once 'footer.php'; ?>
	</div>
	<script type="text/javascript">
		$(document).ready(function () {
			$('#jtable_div').jtable({
				title: '<?php dic_show('Buy & Sell'); ?>',
				paging: true,
				pageSize: 10,
				sorting: true,
				defaultSorting: 'id DESC',
				actions: {
					listAction: 'control/buy_sell.control.php?action=list_today',
					createAction: 'control/buy_sell.control.php?action=create',
					updateAction: 'control/buy_sell.control.php?action=update',
					deleteAction: 'control/buy_sell.control.php?action=delete'
				},
				fields: {	
					id: {
						title: '<?php dic_show("NO"); ?>',
						key: true,
						create: false,
						edit: false,
						//list: false
					},
					
					id_user: {
						title: '<?php dic_show("User"); ?>',
						create: false,
						edit: false,
						list: false
					},
					
					id_account_buy:{
						title: '<?php dic_show("Buy"); ?>',
						options : 'control/accounts.control.php?action=json_list&part=payouts'
					},
					date_time:{
						title: '<?php dic_show("Date"); ?>',
						type: 'dateTime',
						create:false,
						edit:false
					},
					amount: {
						title: '<?php dic_show("Amounts"); ?>'
					},
					
					
					buy_rate: {
						title: '<?php dic_show("Buy Rate"); ?>'
					},
					total_buying: {
						title: '<?php dic_show("کۆی کرین"); ?>',
						create:false,
						sorting:false,
						edit:false
					},
					detail_buy: {
						title: '<?php dic_show("تێبینی کرین"); ?>',
					},
					id_account_sell:{
						title: '<?php dic_show("Sell"); ?>',
						options : 'control/accounts.control.php?action=json_list&part=payouts'
					},
					
					sell_rate: {
						title: '<?php dic_show("Sell Rate"); ?>'
					},
					total_selling: {
						title: '<?php dic_show("کۆی فرۆش"); ?>',
						create:false,
						sorting:false,
						edit:false
					},
					detail_sell: {
						title: '<?php dic_show("تێبینی فرۆش"); ?>',
					},
					type:{
						title: '<?php dic_show("type"); ?>',
						options : {'1':'/','2':'*','3':'=','4':'$'},
						list: false
					},
				}
			});
			$('#jtable_div').jtable('load');
		});

		$('body').on('click','.jtable-toolbar-item-add-record',function(){
			//alert('ddddd');
			$('.ui-dialog').width('900px');
			var width_view = parseInt($(window).width());
			var from_left = (width_view - 830)/2;
			$('.ui-dialog').css('left',from_left+'px');
			
			$('.jtable-input-field-container').css('float','right');
			
			$('.jtable-input-field-container:eq(2)').after('<div class="jtable-input-field-container" style="float: right;"><div class="jtable-input-label">.</div><div class="jtable-input jtable-text-input"><input  id="" type="text" value="<-" style="width:20px;" disabled></div></div><div class="jtable-input-field-container" style="float: right;"><div class="jtable-input-label">کۆی کرین</div><div class="jtable-input jtable-text-input"><input class="total_buy" id="total_buy" type="text" name="total_buy" disabled></div></div>');
			//alert(width_view);
			$('.jtable-input-field-container:eq(6)').after('<div class="jtable-input-field-container" style="float: right;"><div class="jtable-input-label">بر</div><div class="jtable-input jtable-text-input"><input class="amount2" id="amount2" type="text" name="amount2" disabled></div></div>');
			console.log($('.jtable-input-field-container:eq(2)'));
			
			$('.jtable-input-field-container:eq(8)').after('<div class="jtable-input-field-container" style="float: right;"><div class="jtable-input-label">.</div><div class="jtable-input jtable-text-input"><input  id="" type="text" value="<-" style="width:20px;" disabled></div></div><div class="jtable-input-field-container" style="float: right;"><div class="jtable-input-label">کۆی فرۆش</div><div class="jtable-input jtable-text-input"><input class="total_sell" id="total_sell" type="text" name="total_sell" disabled></div></div>');
			
		});
		
		$('body').on('click','.jtable-command-button',function(){
			// alert('ddddd');
			$('.ui-dialog').width('800px');

			
		});
		
		$('body').on('change keyup','#Edit-amount, #Edit-buy_rate, #Edit-sell_rate, #Edit-type',function(){
			//$('#total_buy').val($(this).val());
			calculate_state();
		});
		
		function calculate_state(){
			// console.log($('#Edit-type').val());
			var amount = parseFloat($('#Edit-amount').val());
			var rate_buy = parseFloat($('#Edit-buy_rate').val());
			var rate_sell = parseFloat($('#Edit-sell_rate').val());
			if($('#Edit-type').val() == 1){
				var total_buy = Math.round(amount / rate_buy);
				//console.log(amount,rate_buy);
				$('#total_buy').val(total_buy);
				$('#amount2').val(amount);
				// $('#total_sell').val(Math.round(total_buy * rate_sell / rate_buy));
				$('#total_sell').val(Math.round(amount / rate_sell ));
			}
			else if($('#Edit-type').val() == 2){
				var total_buy = Math.round(amount * rate_buy * 10000) / 10000;
				$('#total_buy').val(total_buy);
				$('#amount2').val(amount);
				$('#total_sell').val(Math.round(total_buy * rate_sell / rate_buy ) );
			}
			else if($('#Edit-type').val() == 3){
				var total_buy = Math.round(amount);
				$('#total_buy').val(total_buy);
				$('#amount2').val(amount);
				$('#total_sell').val(Math.round(amount));
			}
			else if($('#Edit-type').val() == 4){
				var total_buy = Math.round(amount);
				$('#total_buy').val(total_buy);
				$('#amount2').val(amount);
				$('#total_sell').val(Math.round(amount *  rate_sell / rate_buy));
			}
		}
	</script>
 
  </body>
		<script>
		
		</script>
</html>
