<?php
	require_once 'class/database.class.php';
?>
<html>
<?php require_once 'head_tag.php'; ?>
  <body>
  	<div id="wrapper">
  		<?php require_once 'nav.php'; ?>
  		<div id="main">
			<div id="jtable_div" style="width: 800px;"></div>
		</div>
		<?php require_once 'footer.php'; ?>
	</div>
	<script type="text/javascript">
		$(document).ready(function () {
			$('#jtable_div').jtable({
				title: '<?php dic_show('Expense'); ?>',
				paging: true,
				pageSize: 10,
				sorting: true,
				defaultSorting: 'id DESC',
				actions: {
					listAction: 'control/expense.control.php?action=list',
					createAction: 'control/expense.control.php?action=create',
					updateAction: 'control/expense.control.php?action=update',
					deleteAction: 'control/expense.control.php?action=delete'
				},
				fields: {	
					// facture_detail:{
					// 	title: '',
	    //                 width: '2%',
	    //                 sorting: false,
	    //                 edit: false,
	    //                 create: false,
	    //                 display: function (std) {
     //                    var $img = $('<img src="images/list_metro.png" title="click to open" />');
     //                    $img.click(function () {
     //                        $('#jtable_div').jtable('openChildTable',
     //                                $img.closest('tr'),
     //                                {
     //                                    title: '<?php dic_show('account detail:'); ?>' + std.record.id + ' ',
     //                                    actions: {
     //                                    	listAction: 'control/expense.control.php?action=detail_lists&id_account='+std.record.id,
					// 						createAction: false,
					// 						updateAction: false,
					// 						deleteAction: false
					// 					},
					// 					fields: {
					// 						id: {
					// 							key: true,
					// 							list:false
					// 						},
					// 						balance: {
					// 							title: '<?php dic_show("Balance"); ?>'
					// 						},
					// 						income: {
					// 							title: '<?php dic_show("Payment"); ?>'
					// 						},
					// 						outcome: {
					// 							title: '<?php dic_show("Payout"); ?>'
					// 						},
					// 						date:{
					// 							title: '<?php dic_show("Date"); ?>',
					// 							type: 'date'
					// 						}
					// 					}
     //                                }, function (data) {
     //                                    data.childTable.jtable('load');
     //                            });
     //                    });
     //                    return $img;
     //                	}
					// },
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
					description: {
						title: '<?php dic_show("Description"); ?>'
					},
					detail: {
						title: '<?php dic_show("detail"); ?>',
						type: 'textarea'
					}
				}
			});
			$('#jtable_div').jtable('load');
		});

	</script>
 
  </body>
</html>
