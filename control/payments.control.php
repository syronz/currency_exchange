<?php
require_once '../class/payments.class.php';

switch ($_GET['action']) {
	case 'list':
		echo payments::lists($_GET["jtSorting"],$_GET["jtStartIndex"],$_GET["jtPageSize"]);
	//echo '{"Result":"OK","TotalRecordCount":"1","Records":[{"id":"1","id_user":"0","id_account":"1","amount":"25.00","date":"2013-12-12 00:00:00"}]}';
		break;
	case 'create':
		echo payments::create($_POST);
		break;
	case 'update':
		echo payments::update($_POST);
		break;
	case 'delete':
		echo payments::delete($_POST['id']);
		break;
	case 'json_list':
		echo payments::json_list(@$_GET['id_department'],$_GET['part']);
		break;

	
	
	default:
		
		break;
}




?>