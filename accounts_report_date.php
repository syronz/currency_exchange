<?php
	require_once 'class/database.class.php';
	require_once 'class/accounts.class.php';
	$acount_info = accounts::get_accounts_info($_GET["id_account"]);
?>
<html>
<?php require_once 'head_tag.php'; ?>
  <body>
  	<div id="wrapper">
  		<?php require_once 'nav.php'; ?>
		<div id="main">
			<div id="jtable_div" style="width: 900px;"></div>
		</div>
		<?php require_once 'footer.php'; ?>
	</div>
	<script type="text/javascript">
		$(document).ready(function () {

		    //Prepare jTable
			$('#jtable_div').jtable({
				title: ' <?php echo $acount_info['owner_name'].' '.$_GET["start_date"].' / '.$_GET["end_date"]; ?> <?php dic_show('رێپۆرتی ئەکاونت'); ?> ' ,
				paging: true,
				pageSize: 10,
				sorting: true,
				defaultSorting: 'id ASC',
				actions: {
					listAction: 'control/accounts.control.php?action=account_report_date&start_date=<?php echo $_GET["start_date"]; ?>&end_date=<?php echo $_GET["end_date"]; ?>&id_account=<?php echo $_GET["id_account"]; ?>',
					createAction: false,
					updateAction: false,
					deleteAction: false,
				},
				fields: {
				
					id: {
						title: '<?php dic_show("NO"); ?>',
						key: true,
						create: false,
						edit: false,
						sorting:false
						//list: false
					},
					
					date_time: {
						title: '<?php dic_show("date"); ?>',
						sorting:false
					},
					type: {
						title: '<?php dic_show("type"); ?>',
						options: {'sell':'فرۆش','buy':'کرین','loan_payment':'وەرگرتنی قەرز','loan_payout':'پێدانی قەرز','order_payment':'وەرگرتنی حەوالە','order_payout':'پێدانی حەوالە'},
						sorting:false
					},
					detail: {
						title: '<?php dic_show("detail"); ?>',
						sorting:false
					},
					p_dollar: {
						title: '<?php dic_show("send"); ?>',
						sorting:false
					},
					m_dollar: {
						title: '<?php dic_show("give"); ?>',
						sorting:false
					},
					balance: {
						title: '<?php dic_show("balance"); ?>',
						create:false,
						edit:false
					}
					
				}
			});

			//Load person list from server
			$('#jtable_div').jtable('load');

		});

	</script>
 
  </body>
</html>
