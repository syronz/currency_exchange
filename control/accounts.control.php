<?php
require_once '../class/accounts.class.php';

switch ($_GET['action']) {
	case 'list':
		echo accounts::lists($_GET["jtSorting"],$_GET["jtStartIndex"],$_GET["jtPageSize"]);
		break;
	case 'create':
//		file_put_contents('a.txt', print_r($_POST,true));
		echo accounts::create($_POST);
		break;
	case 'update':
		echo accounts::update($_POST);
		break;
	case 'delete':
		echo accounts::delete($_POST['id']);
		break;
	case 'json_list':
		echo accounts::json_list(@$_GET['part']);
		break;

	case 'detail_lists':
		echo accounts::detail_lists($_GET['id_account']);
		break;

	case 'list_report':
		echo accounts::list_report(@$_GET["jtSorting"],@$_GET["jtStartIndex"],@$_GET["jtPageSize"],@$_GET['date']);
		break;
	case 'account_report_date':
		echo accounts::account_report_date(@$_GET["jtSorting"],@$_GET["jtStartIndex"],@$_GET["jtPageSize"],@$_GET['start_date'],@$_GET['end_date'],@$_GET['id_account']);
		break;
	default:
		
		break;
}




?>