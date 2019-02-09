<?php
require_once '../class/order_payment.class.php';

switch ($_GET['action']) {
	case 'list':
		echo order_payment::lists($_GET["jtSorting"],$_GET["jtStartIndex"],$_GET["jtPageSize"]);
		break;
	case 'create':
		// file_put_contents('a.txt', print_r($_POST,true));
		echo order_payment::create($_POST);
		break;
	case 'update':
		echo order_payment::update($_POST);
		break;
	case 'delete':
		echo order_payment::delete($_POST['id']);
		break;
	case 'json_list':
		echo order_payment::json_list(@$_GET['part']);
		break;

	case 'detail_lists':
		echo order_payment::detail_lists($_GET['id_account']);
		break;

	case 'psula_list':
		echo order_payment::psula_lists($_GET["jtSorting"],$_GET["jtStartIndex"],$_GET["jtPageSize"]);
		break;
	case 'psula_create':
		// file_put_contents('a.txt', print_r($_POST,true));
		echo order_payment::psula_create($_POST);
		break;
	case 'psula_update':
		echo order_payment::psula_update($_POST);
		break;
	case 'psula_delete':
		echo order_payment::psula_delete($_POST['id']);
		break;
	
	default:
		
		break;
}




?>