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
			<div id="jtable_div" style="width: 900px;"></div>
		</div>
		<?php require_once 'footer.php'; ?>
	</div>
	<script type="text/javascript">
		$(document).ready(function () {

		    //Prepare jTable
			$('#jtable_div').jtable({
				title: 'User Activity',
				paging: true,
				pageSize: 10,
				sorting: true,
				defaultSorting: 'id DESC',
				actions: {
					listAction: 'control/user_activity.control.php?action=list',
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
					ip: {
						title: 'IP',
						create: false,
						edit: false,
					},
					id_user: {
						title: 'User',
						//options : 'control/accounts.control.php?action=json_list&part=user_activity'
						list:false
					},
					action: {
						title: 'action'
					},
					detail: {
						title: 'detail'
					},
					date:{
						title: 'Date'
					}
				}
			});

			//Load person list from server
			$('#jtable_div').jtable('load');

		});

	</script>
 
  </body>
</html>
