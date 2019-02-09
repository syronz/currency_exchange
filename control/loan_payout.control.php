<?php
require_once '../class/loan_payout.class.php';

switch ($_GET['action']) {
	case 'list':
		echo loan_payout::lists($_GET["jtSorting"],$_GET["jtStartIndex"],$_GET["jtPageSize"]);
		break;
	case 'create':
		echo loan_payout::create($_POST);
		break;
	case 'update':
		echo loan_payout::update($_POST);
		break;
	case 'delete':
		echo loan_payout::delete($_POST['id']);
		break;
	case 'json_list':
		echo loan_payout::json_list(@$_GET['part']);
		break;

	case 'detail_lists':
		echo loan_payout::detail_lists($_GET['id_account']);
		break;
	
	default:
		
		break;
}




?>