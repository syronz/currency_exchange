<?php
require_once '../class/order_payout.class.php';

switch ($_GET['action']) {
	case 'list':
		echo order_payout::lists($_GET["jtSorting"],$_GET["jtStartIndex"],$_GET["jtPageSize"]);
		break;
	case 'create':
		// file_put_contents('a.txt', print_r($_POST,true));
		echo order_payout::create($_POST);
		break;
	case 'update':
		echo order_payout::update($_POST);
		break;
	case 'delete':
		echo order_payout::delete($_POST['id']);
		break;
	case 'json_list':
		echo order_payout::json_list(@$_GET['part']);
		break;

	case 'detail_lists':
		echo order_payout::detail_lists($_GET['id_account']);
		break;
	
	default:
		
		break;
}




?>