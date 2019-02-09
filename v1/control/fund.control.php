<?php
require_once '../class/fund.class.php';

switch ($_GET['action']) {
	case 'list':
		echo fund::lists($_GET["jtSorting"],$_GET["jtStartIndex"],$_GET["jtPageSize"]);
		break;
	case 'create':
//		file_put_contents('a.txt', print_r($_POST,true));
		echo fund::create($_POST);
		break;
	case 'update':
		echo fund::update($_POST);
		break;
	case 'delete':
		echo fund::delete($_POST['id']);
		break;
	case 'json_list':
		echo fund::json_list(@$_GET['part']);
		break;

	case 'detail_lists':
		echo fund::detail_lists($_GET['id_account']);
		break;

	case 'list_daily':
		echo fund::list_daily($_GET["jtSorting"],$_GET["jtStartIndex"],$_GET["jtPageSize"],$_GET['date']);
		break;
	
	case 'list_today':
		echo fund::list_today($_GET["jtSorting"],$_GET["jtStartIndex"],$_GET["jtPageSize"]);
		break;
	
	default:
		
		break;
}




?>