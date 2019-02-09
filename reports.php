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
  	<style>
  		.jtable-command-column,.jtable-command-column-header{
  			display: none;
  		}
  	</style>
  	<div id="wrapper">
  		<?php require_once 'nav.php'; ?>
  		<div class="navigation center">
  			<a href="reports.php?year=2010" ><button><?php dic_show('2010'); ?></button></a>
  			<a href="reports.php?year=2011" ><button><?php dic_show('2011'); ?></button></a>
  			<a href="reports.php?year=2012" ><button><?php dic_show('2012'); ?></button></a>
  			<a href="reports.php?year=2013" ><button><?php dic_show('2013'); ?></button></a>
  			<a href="reports.php?year=2014" ><button><?php dic_show('2014'); ?></button></a>
  			<a href="reports.php?year=2015" ><button><?php dic_show('2015'); ?></button></a>
  		</div>
		<div id="jtable_div" style="width: 1040px;"></div>
		<div id="footer">Created By <a target="_blanc" href="http://about.me/diako.amir">Diako Amir</a> [sabina.diako@gmail.com]</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function () {

		    //Prepare jTable
			$('#jtable_div').jtable({
				title: 'Reports For Payments - <?php echo $_GET["year"]; ?>',
				paging: true,
				pageSize: 10,
				sorting: true,
				defaultSorting: 'id_account ASC',
				actions: {
					listAction: 'control/reports.control.php?action=list&year=<?php echo $_GET["year"]; ?>',
					createAction: false,
					updateAction: 'control/accounts.control.php?action=update',
					deleteAction: 'control/accounts.control.php?action=delete'
				},
				fields: {
					
					id_account: {
						title: 'Account NO',
						key: true,
						create: false,
						edit: false,
						options: 'control/accounts.control.php?action=json_list&part=reports',
						width: '10%'
						//list: false
					},
					Jan: {
						title: 'Jan',
						width: '7%',
						sorting: false
					},
					Feb: {
						title: 'Feb',
						width: '7%',
						sorting: false
					},
					Mar: {
						title: 'Mar',
						width: '7%',
						sorting: false
					},
					Apr: {
						title: 'Apr',
						width: '7%',
						sorting: false
					},
					May: {
						title: 'May',
						width: '7%',
						sorting: false
					},
					Jun: {
						title: 'Jun',
						width: '7%',
						sorting: false
					},
					Jul: {
						title: 'Jul',
						width: '7%',
						sorting: false
					},
					Aug: {
						title: 'Aug',
						width: '7%',
						sorting: false
					},
					Sep: {
						title: 'Sep',
						width: '7%',
						sorting: false
					},
					Oct: {
						title: 'Oct',
						width: '7%',
						sorting: false
					},
					Nov: {
						title: 'Nov',
						width: '7%',
						sorting: false
					},
					Dec: {
						title: 'Dec',
						width: '7%',
						sorting: false
					},
					total: {
						title: 'Total',
						width: '7%',
						sorting: false
					}/**/

				}
			});

			//Load person list from server
			$('#jtable_div').jtable('load');

		});

	</script>
 
  </body>
</html>
