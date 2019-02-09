<?php
require_once '../class/buy_sell.class.php';

switch ($_GET['action']) {
	case 'list':
		echo buy_sell::lists($_GET["jtSorting"],$_GET["jtStartIndex"],$_GET["jtPageSize"]);
		break;
	case 'create':
		echo buy_sell::create($_POST);
		break;
	case 'update':
		echo buy_sell::update($_POST);
		break;
	case 'delete':
		echo buy_sell::delete($_POST['id']);
		break;
	
	case 'list_today':
		echo buy_sell::list_today($_GET["jtSorting"],$_GET["jtStartIndex"],$_GET["jtPageSize"]);
		break;
	
	default:
		
		break;
}




?>