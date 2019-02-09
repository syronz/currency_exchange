<?php
	require_once 'class/database.class.php';
?>
<html>
<?php require_once 'head_tag.php'; ?>
  <body>
  	<style>
  		.jtable-command-column,.jtable-command-column-header{
  			display: none;
  		}
  	</style>
  	<div id="wrapper">
  		<?php require_once 'nav.php'; ?>
  		<div id="main">
			<div style="text-align: center; margin-top: 20px;">
				<a href="backup.php" ><button style="padding:4px 25px 4px 25px; font-family: tahoma; font-size: 18px;"><?php dic_show('Backup'); ?></button></a>
			</div>
			
			<div id="jtable_div" style="width: 900px;"></div>
		</div>
		<?php require_once 'footer.php'; ?>
	</div>
	<script type="text/javascript">
		$(document).ready(function () {

		    //Prepare jTable
			$('#jtable_div').jtable({
				title: 'رێستۆر',
				paging: true,
				pageSize: 10,
				sorting: true,
				defaultSorting: 'id DESC',
				actions: {
					listAction: 'control/backup_page.control.php?action=list',
					createAction: false,
					updateAction: false,
					deleteAction: false
				},
				fields: {
					id: {
						title: 'ID',
						key: true,
						create: false,
						edit: false,
					},
					name: {
						title: 'Name',
						create: false,
						edit: false,
						sorting: false
					},
					restore: {
						title: 'Restore',
						create: false,
						edit: false,
						sorting: false
					},
				}
			});

			//Load person list from server
			$('#jtable_div').jtable('load');

		});

	</script>
 
  </body>
</html>
