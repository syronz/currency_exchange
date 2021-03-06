<?php
	require_once 'class/database.class.php';
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
			$('#jtable_div').jtable({
				title: '<?php dic_show('Loan Payout'); ?>',
				paging: true,
				pageSize: 10,
				sorting: true,
				defaultSorting: 'id DESC',
				actions: {
					listAction: 'control/loan_payout.control.php?action=list',
					createAction: 'control/loan_payout.control.php?action=create',
					updateAction: 'control/loan_payout.control.php?action=update',
					deleteAction: 'control/loan_payout.control.php?action=delete'
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
						title: '<?php dic_show("Account"); ?>',
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
					detail: {
						title: '<?php dic_show("detail"); ?>',
						type: 'textarea'
					},
					loss: {
						title: '<?php dic_show(""); ?>',
						type: 'checkbox',
                		values: { 0: '<?php dic_show("regular"); ?>', 1: '<?php dic_show("profit"); ?>' },
                		// defaultValue: '0',
                		list: false
					}
				}
			});
			$('#jtable_div').jtable('load');
		});

	</script>
 
  </body>
</html>
