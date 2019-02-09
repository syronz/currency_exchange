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

		    //Prepare jTable
			$('#jtable_div').jtable({
				title: '<?php echo $_GET["date"]; ?> <?php dic_show('جەردی قەرزی'); ?> ' ,
				paging: true,
				pageSize: 10,
				sorting: true,
				defaultSorting: 'id ASC',
				actions: {
					listAction: 'control/accounts.control.php?action=list_report&date=<?php echo $_GET["date"]; ?>',
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
					name_p: {
						title: '<?php dic_show("Creditor"); ?>',
						sorting:false
					},
					amount_p: {
						title: '<?php dic_show("Amount"); ?>',
						sorting:false
					},
					space: {
						title: '<?php dic_show(" "); ?>',
						sorting:false
					},
					// balance: {
					// 	title: '<?php dic_show("Balance"); ?>',
					// 	create:false,
					// 	edit:false
					// },
					name_m: {
						title: '<?php dic_show("Debtor"); ?>',
						sorting:false
					},
					amount_m: {
						title: '<?php dic_show("Amount"); ?>',
						sorting:false
					}
					
				}
			});

			//Load person list from server
			$('#jtable_div').jtable('load');

		});

	</script>
 
  </body>
</html>
