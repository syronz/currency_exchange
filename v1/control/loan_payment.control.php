<?php
require_once '../class/loan_payment.class.php';

switch ($_GET['action']) {
	case 'list':
		echo loan_payment::lists($_GET["jtSorting"],$_GET["jtStartIndex"],$_GET["jtPageSize"]);
		break;
	case 'create':
		echo loan_payment::create($_POST);
		break;
	case 'update':
		echo loan_payment::update($_POST);
		break;
	case 'delete':
		echo loan_payment::delete($_POST['id']);
		break;
	case 'json_list':
		echo loan_payment::json_list(@$_GET['part']);
		break;

	case 'detail_lists':
		echo loan_payment::detail_lists($_GET['id_account']);
		break;
	
	default:
		
		break;
}




?>