<?php
	require_once 'class/database.class.php';
?>
<html>
<?php require_once 'head_tag.php'; ?>
  <body>
  	<style>
  		
	</style>
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
				title: '<?php dic_show('Fund For Day '); echo $_GET["date"]; ?>',
				paging: true,
				pageSize: 10,
				sorting: true,
				defaultSorting: 'id ASC',
				actions: {
					listAction: 'control/fund.control.php?action=list_daily&date=<?php echo $_GET["date"]; ?>',
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
						//list: false
					},
					id_user: {
						title: '<?php dic_show("User"); ?>',
						create: false,
						edit: false,
						list: false
					},
					
					type: {
						title: '<?php dic_show("Type"); ?>',
						//loan_payment loan_payout   
						options:{'loan_payment':'وەرگرتنی پاره', 'loan_payout':'پێدانی پارە', 'expense':'خەرج', 'order_payment':'حەوالەوەرگرتن', 'order_payout':'حەوالەدان', 'exchange':'گۆرین'},
						create: false,
						edit: false,
					},
					id_f:{
						title: '<?php dic_show("id_f"); ?>',
						create: false,
						edit: false,
						list: false
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
					date_time:{
						title: '<?php dic_show("Date"); ?>',
						// type: 'dateTime',
						create:false,
						edit: false,
					},
					detail: {
						title: '<?php dic_show("detail"); ?>',
						type: 'textarea'
					},
					box_dollar: {
						title: '<?php dic_show("Box $"); ?>',
						create: false,
						edit: false
					},
					// box_dinar: {
					// 	title: '<?php dic_show("Box IQD"); ?>',
					// 	create: false,
					// 	edit: false
					// },
					// box_tman: {
					// 	title: '<?php dic_show("Box Tman"); ?>',
					// 	create: false,
					// 	edit: false
					// }				
				}
			});

			//Load person list from server
			$('#jtable_div').jtable('load');



		});

	</script>
 
  </body>
</html>
