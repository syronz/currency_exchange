<?php
require_once '../class/expense.class.php';

switch ($_GET['action']) {
	case 'list':
		echo expense::lists($_GET["jtSorting"],$_GET["jtStartIndex"],$_GET["jtPageSize"]);
		break;
	case 'create':
		echo expense::create($_POST);
		break;
	case 'update':
		echo expense::update($_POST);
		break;
	case 'delete':
		echo expense::delete($_POST['id']);
		break;
	case 'json_list':
		echo expense::json_list(@$_GET['part']);
		break;

	case 'detail_lists':
		echo expense::detail_lists($_GET['id_account']);
		break;
	
	default:
		
		break;
}




?>