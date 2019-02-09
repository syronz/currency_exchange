<?php
	require_once 'class/database.class.php';
?>
<html>
<?php require_once 'head_tag.php'; ?>
  <body>
  	<div id="wrapper">
  		<?php require_once 'nav.php'; ?>
  		<div id="main">
			<div id="jtable_div" style="width: 1300px;"></div>
		</div>
		<?php require_once 'footer.php'; ?>
	</div>
	<script type="text/javascript">
		$(document).ready(function () {
			$('#jtable_div').jtable({
				title: '<?php dic_show('Order Payment'); ?>',
				paging: true,
				pageSize: 10,
				sorting: true,
				defaultSorting: 'id DESC',
				actions: {
					listAction: 'control/order_payment.control.php?action=list',
					createAction: 'control/order_payment.control.php?action=create',
					updateAction: 'control/order_payment.control.php?action=update',
					deleteAction: 'control/order_payment.control.php?action=delete'
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
					id_account:{
						title: '<?php dic_show("By Account"); ?>',
						options : 'control/accounts.control.php?action=json_list&part=payouts'
					},
					date_time:{
						title: '<?php dic_show("Date"); ?>',
						type: 'dateTime',
						create:false,
						edit:false
					},
					a_dollar: {
						title: '<?php dic_show("Amount $"); ?>'
					},
					// a_dinar: {
					// 	title: '<?php dic_show("Amount IQD"); ?>'
					// },
					// a_tman: {
					// 	title: '<?php dic_show("Amount Tman"); ?>'
					// },
					cost: {
						title: '<?php dic_show("Cost"); ?>'
					},
					sender_name: {
						title: '<?php dic_show("Sender Name"); ?>'
					},
					sender_phone: {
						title: '<?php dic_show("Sender Phone"); ?>'
					},
					reciever_name: {
						title: '<?php dic_show("Reciever Name"); ?>'
					},
					reciever_phone: {
						title: '<?php dic_show("Reciever Phone"); ?>'
					},
					reciever_address: {
						title: '<?php dic_show("Reciever Address"); ?>'
					},
					state: {
						title: '<?php dic_show("State"); ?>',
						create: false,
						edit: false,
						list: false
					},
					detail: {
						title: '<?php dic_show("detail"); ?>',
						type: 'textarea'
					},
					view:{
						title: '',
	                    width: '2%',
	                    sorting: false,
	                    edit: false,
	                    create: false,
	                    display: function (std) {
	                        var $img = $('<img src="images/list_metro.png" title="<?php dic_show('View Facture'); ?>" />');
	                        //Open child table when user clicks the image
	                        $img.click(function () {
	                        	// alert('ok, it\'s work');
	                        	window.location.href = 'order_payment_view.php?id='+std.record.id;
	                        	// $('#loading').css('display','block');
		                        // $('main').load('include/sell_facture_view_ku.php?id_sell_facture='+std.record.id,function(response, status, xhr){
		                        // 	$('#loading').css('display','none');
		                        // });
	                        });
	                        //Return image to show on the person row
	                        return $img;
                    	}
					}
				}
			});
			$('#jtable_div').jtable('load');
		});

	</script>
 
  </body>
</html>
