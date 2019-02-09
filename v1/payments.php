<?php
	require_once 'class/database.class.php';
?>
<html>
  <head>

    <link href="themes/redmond/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css" />
	<link href="scripts/jtable.2.3.1/themes/metro/blue/jtable.css" rel="stylesheet" type="text/css" />
	
	<script src="scripts/jquery-1.10.2.min.js" type="text/javascript"></script>
    <script src="scripts/jquery-ui-1.10.3.custom.js" type="text/javascript"></script>
    <script src="scripts/jtable.2.3.1/jquery.jtable.js" type="text/javascript"></script>
    <meta charset="utf-8" >
	<link rel="stylesheet" type="text/css" href="style.css">
  </head>
  <body>
  	<div id="wrapper">
  		<?php require_once 'nav.php'; ?>
		<div id="jtable_div" style="width: 600px;"></div>
		<div id="footer" class="clear">Created By <a target="_blanc" href="http://about.me/diako.amir">Diako Amir</a> [sabina.diako@gmail.com]</div>
	</div>
	<script type="text/javascript">
/**/
		$(document).ready(function () {

		    //Prepare jTable
			$('#jtable_div').jtable({
				title: 'Table of Payments',
				paging: true,
				pageSize: 10,
				sorting: true,
				defaultSorting: 'id ASC',
				actions: {
					listAction: 'control/payments.control.php?action=list',
					createAction: 'control/payments.control.php?action=create',
					updateAction: 'control/payments.control.php?action=update',
					deleteAction: 'control/payments.control.php?action=delete'
				},
				fields: {
					id: {
						key: true,
						create: false,
						edit: false,
						//list: false
					},
					id_user: {
						title: 'User',
						create: false,
						edit: false,
						list: false
					},
					id_account: {
						title: 'Account Number',
						options : 'control/accounts.control.php?action=json_list&part=payments'
					},
					amount: {
						title: 'Amount'
					},
					date:{
						title: 'Date',
						type:'date'
					}
				}
			});

			//Load person list from server
			$('#jtable_div').jtable('load');

		});

	</script>
 
  </body>
</html>
