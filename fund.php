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
				title: '<?php dic_show('Fund'); ?>',
				paging: true, 
				pageSize: 10,
				sorting: true,
				defaultSorting: 'id DESC',
				actions: {
					listAction: 'control/fund.control.php?action=list',
					createAction: 'control/fund.control.php?action=create',
					updateAction: 'control/fund.control.php?action=update',
					deleteAction: 'control/fund.control.php?action=delete'
				},
				fields: {
					
					// facture_detail:{
					// 	title: '',
	    //                 width: '2%',
	    //                 sorting: false,
	    //                 edit: false,
	    //                 create: false,
	    //                 display: function (std) {
     //                    //Create an image that will be used to open child table
     //                    var $img = $('<img src="images/list_metro.png" title="click to open" />');
     //                    //Open child table when user clicks the image
     //                    $img.click(function () {
     //                        $('#jtable_div').jtable('openChildTable',
     //                                $img.closest('tr'),
     //                                {
     //                                    title: '<?php dic_show('account detail:'); ?>' + std.record.id + ' ',
     //                                    actions: {
     //                                    	listAction: 'control/fund.control.php?action=detail_lists&id_account='+std.record.id,
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
     //                                }, function (data) { //opened handler
     //                                    data.childTable.jtable('load');
     //                            });
     //                    });
     //                    //Return image to show on the person row
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
					
					type: {
						title: '<?php dic_show("Type"); ?>',
						options:{'loan_payout':'پێدانی پارە', 'loan_payment':'وەرگرتنی پاره', 'expense':'خەرج', 'order_payment':'حەوالەوەرگرتن', 'order_payout':'حەوالەدان', 'exchange':'گۆرین','to fund':'دەستی'},
						
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
