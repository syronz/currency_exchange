<?php
require_once '../class/reports.class.php';

switch ($_GET['action']) {
	case 'list':
		echo reports::lists($_GET["jtSorting"],$_GET["jtStartIndex"],$_GET["jtPageSize"],@$_GET['year']);
	//echo '{"Result":"OK","TotalRecordCount":"4","Records":[{"Dec":"1700.00","id_account":1},{"Dec":"1000.00","id_account":3},{"Oct":"400.00","Dec":"1200.00","id_account":4}]}';
		break;
	case 'create':
		echo reports::create($_POST);
		break;
	case 'update':
		echo reports::update($_POST);
		break;
	case 'delete':
		echo reports::delete($_POST['id']);
		break;
	case 'json_list':
		echo reports::json_list(@$_GET['part']);
		break;

	case 'detail_lists':
		echo reports::detail_lists($_GET['id_account']);
		break;
	
	default:
		
		break;
}




?>