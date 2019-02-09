<?php
require_once 'database.class.php';

class fund extends database{
	private static $TABLE = 'fund';

	public static function calculate_row(){
		try{
			$sql = "SELECT count(id) AS count FROM ".self::$TABLE;
			$result = self::$PDO->query($sql);
			$count = $result->fetchObject();
			return $count->count;
		}
		catch(PDOException $e){
			echo 'Error: [fund.class.php/function calculate_row]'.$e->getMessage().'<br>';
			die();
		}
	}

	private static function calculate_balance($id_account){
		try{
			$sql = "SELECT SUM(amount) AS total_payments FROM payments WHERE id_account = '$id_account'";
			$result = self::$PDO->query($sql);
			$row = $result->fetch(PDO::FETCH_ASSOC);
			$total_payments = $row['total_payments'];

			$sql = "SELECT SUM(amount) AS total_payouts FROM payouts WHERE id_account = '$id_account'";
			$result = self::$PDO->query($sql);
			$row = $result->fetch(PDO::FETCH_ASSOC);
			$total_payouts = $row['total_payouts'];

			return ($total_payments - $total_payouts);
		}
		catch(PDOException $e){
			echo 'Error: [fund.class.php/function calculate_balance]'.$e->getMessage().'<br>';
			die();
		}
	}
	public static function lists($sorting,$startIndex,$pageSize){
		try{
			self::hack_pageSize($startIndex,$pageSize);
			$sorting = self::hack_sorting($sorting);
			$date = date('Y-m-d',time());
			//$sql = "SELECT * FROM ".self::$TABLE." WHERE date_time LIKE '$date%' ORDER BY $sorting LIMIT $startIndex, $pageSize;";
			$sql = "SELECT * FROM ".self::$TABLE." ORDER BY $sorting LIMIT $startIndex, $pageSize;";
			$result = self::$PDO->query($sql);
			$rows = $result->fetchAll(PDO::FETCH_ASSOC);
			$count = count($rows);

			for($i=0;$i<$count;$i++){
				@$rows[$i]['balance'] = self::calculate_balance($rows[$i]['id']);
				@$rows[$i]['a_dollar'] = dsh_money($rows[$i]['a_dollar']);
				@$rows[$i]['a_dinar'] = dsh_money($rows[$i]['a_dinar']);
				@$rows[$i]['a_tman'] = dsh_money($rows[$i]['a_tman']);
				@$rows[$i]['box_dollar'] = dsh_money($rows[$i]['box_dollar']);
				@$rows[$i]['box_dinar'] = dsh_money($rows[$i]['box_dinar']);
				@$rows[$i]['box_tman'] = dsh_money($rows[$i]['box_tman']);
			}

			//return $rows;
			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			$jTableResult['TotalRecordCount'] = self::calculate_row();
			$jTableResult['Records'] = $rows;
			self::record('read','View '.self::$TABLE.' Table');
			return json_encode($jTableResult);
		}
		catch(PDOException $e){
			echo 'Error: [fund.class.php/function lists]'.$e->getMessage().'<br>';
			die();
		}
	}
	
	public static function list_today($sorting,$startIndex,$pageSize){
		try{
			self::hack_pageSize($startIndex,$pageSize);
			$sorting = self::hack_sorting($sorting);
			$date = date('Y-m-d',time());
			//$sql = "SELECT * FROM ".self::$TABLE." WHERE date_time LIKE '$date%' ORDER BY $sorting LIMIT $startIndex, $pageSize;";
			$sql = "SELECT * FROM ".self::$TABLE." WHERE date_time >= CURDATE() ORDER BY $sorting LIMIT $startIndex, $pageSize;";
			$result = self::$PDO->query($sql);
			$rows = $result->fetchAll(PDO::FETCH_ASSOC);
			$count = count($rows);

			for($i=0;$i<$count;$i++){
				@$rows[$i]['balance'] = self::calculate_balance($rows[$i]['id']);
				@$rows[$i]['a_dollar'] = dsh_money($rows[$i]['a_dollar']);
				@$rows[$i]['a_dinar'] = dsh_money($rows[$i]['a_dinar']);
				@$rows[$i]['a_tman'] = dsh_money($rows[$i]['a_tman']);
				@$rows[$i]['box_dollar'] = dsh_money($rows[$i]['box_dollar']);
				@$rows[$i]['box_dinar'] = dsh_money($rows[$i]['box_dinar']);
				@$rows[$i]['box_tman'] = dsh_money($rows[$i]['box_tman']);
			}

			//return $rows;
			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			$jTableResult['TotalRecordCount'] = self::calculate_row();
			$jTableResult['Records'] = $rows;
			self::record('read','View '.self::$TABLE.' Table');
			return json_encode($jTableResult);
		}
		catch(PDOException $e){
			echo 'Error: [fund.class.php/function list_today]'.$e->getMessage().'<br>';
			die();
		}
	}

	public static function list_daily($sorting,$startIndex,$pageSize,$date){
		try{
			self::hack_pageSize($startIndex,$pageSize);
			$sorting = self::hack_sorting($sorting);
			$sql = "SELECT * FROM ".self::$TABLE." WHERE date_time LIKE '$date%' ORDER BY $sorting LIMIT $startIndex, $pageSize ;";
			$result = self::$PDO->query($sql);
			$rows = $result->fetchAll(PDO::FETCH_ASSOC);
			
			$sql = "SELECT COUNT(id) AS count FROM ".self::$TABLE." WHERE date_time LIKE '$date%' ;";
			$result = self::$PDO->query($sql);
			$row = $result->fetchObject();
			$count = $row->count;

			for($i=0;$i<$count;$i++){
				@$rows[$i]['id'] = $i+1;
				@$rows[$i]['balance'] = self::calculate_balance($rows[$i]['id']);
				@$rows[$i]['a_dollar'] = dsh_money($rows[$i]['a_dollar']);
				@$rows[$i]['a_dinar'] = dsh_money($rows[$i]['a_dinar']);
				@$rows[$i]['a_tman'] = dsh_money($rows[$i]['a_tman']);
				@$rows[$i]['box_dollar'] = dsh_money($rows[$i]['box_dollar']);
				@$rows[$i]['box_dinar'] = dsh_money($rows[$i]['box_dinar']);
				@$rows[$i]['box_tman'] = dsh_money($rows[$i]['box_tman']);
			}

			//return $rows;
			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			$jTableResult['TotalRecordCount'] = $count;
			$jTableResult['Records'] = $rows;
			self::record('read','View '.self::$TABLE.' Table');
			return json_encode($jTableResult);
		}
		catch(PDOException $e){
			echo 'Error: [fund.class.php/function lists]'.$e->getMessage().'<br>';
			die();
		}
	}

	public static function detail_lists($id_account){
		try{
			//$sql = "SELECT * FROM payments WHERE id_account = $id_account";
			$sql = "SELECT amount AS income,null AS outcome,date FROM payments WHERE payments.id_account='$id_account' UNION
					SELECT null,amount,date FROM payouts WHERE payouts.id_account='$id_account'
					ORDER BY date";
			$result = self::$PDO->query($sql);
			$rows = $result->fetchAll(PDO::FETCH_ASSOC);
			$count = count($rows);

			$balance = 0;
			$total_payments = 0;
			$total_payouts = 0;
			for($i=0;$i<$count;$i++){
				$balance = $balance + $rows[$i]['income'] - $rows[$i]['outcome'];
				$rows[$i]['balance'] = $balance;
				$total_payments += $rows[$i]['income'];
				$total_payouts += $rows[$i]['outcome'];
			}
			$rows[$count]['balance'] = 'Total';
			$rows[$count]['income'] = $total_payments;
			$rows[$count]['outcome'] = $total_payouts;

			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			$jTableResult['Records'] = $rows;
			self::record('read','View buy_account\'s Detail');
			return json_encode($jTableResult);
		}
		catch(PDOException $e){

			echo 'Error: [buy_facture.class.php/function lists]'.$e->getMessage().'<br>';
			die();
		}
	}

	public static function last_row_data(){
		try{
			$sql = "SELECT * FROM ".self::$TABLE." WHERE id=LAST_INSERT_ID();";
			$stmt = self::$PDO->query($sql);
			$row = $stmt->fetchObject();
			return $row;
		}
		catch(PDOException $e){
			echo 'Error: [fund.class.php/function last_row_data]'.$e->getMessage().'<br>';
			die();
		}
	}

	public static function pre_fund($id_user){
		try{
			// $sql = "SELECT * FROM ".self::$TABLE." WHERE id_user = $id_user ORDER BY id DESC LIMIT 1;";
			$sql = "SELECT * FROM ".self::$TABLE." ORDER BY id DESC LIMIT 1;";
			$stmt = self::$PDO->query($sql);
			$row = $stmt->fetchObject();
			return $row;
		}
		catch(PDOException $e){
			echo 'Error: [fund.class.php/function last_row_data]'.$e->getMessage().'<br>';
			die();
		}
	}

	public static function create($data){
		try{
//file_put_contents('a.txt', print_r($data,true));
			$pre = self::pre_fund(0);

			if(!isset($data['type'])){
				$data['type'] = 'to fund';
				$data['date_time'] = date('Y-m-d H:i:i:s');
			}
			// // dsh($pre);
			$box_dollar = @$pre->box_dollar + $data['a_dollar'];
			// $box_dinar = @$pre->box_dinar + $data['a_dinar'];
			// $box_tman = @$pre->box_tman + $data['a_tman'];

			$sql = "INSERT INTO ".self::$TABLE."(`id_user`, `date_time`, `type`, `id_f`, `a_dollar`, `a_dinar`, `a_tman`, `detail`, `box_dollar`, `box_dinar`, `box_tman`) VALUES (:id_user,:date_time,:type,:id_f,:a_dollar,:a_dinar,:a_tman,:detail,:box_dollar,:box_dinar,:box_tman);";
			// INSERT INTO `exchange`.`fund` (`id`, `id_user`, `date_time`, `type`, `id_f`, `a_dollar`, `a_dinar`, `a_tman`, `detail`, `box_dollar`, `box_dinar`, `box_tman`) VALUES (NULL, '1', '2014-04-19 00:10:00', 'expense', '3', '-140', '-124000', NULL, 'for test', '500', '0', '0');
			$stmt = self::$PDO->prepare($sql);
			$stmt->bindParam(':id_user',$data['id_user'],PDO::PARAM_STR);
			$stmt->bindParam(':date_time',$data['date_time'],PDO::PARAM_STR);
			$stmt->bindParam(':type',$data['type'],PDO::PARAM_STR);
			$stmt->bindParam(':id_f',$data['id_f'],PDO::PARAM_STR);
			$stmt->bindParam(':a_dollar',$data['a_dollar'],PDO::PARAM_STR);
			$stmt->bindParam(':a_dinar',$data['a_dinar'],PDO::PARAM_STR);
			$stmt->bindParam(':a_tman',$data['a_tman'],PDO::PARAM_STR);
			$stmt->bindParam(':detail',$data['detail'],PDO::PARAM_STR);
			$stmt->bindParam(':box_dollar',$box_dollar,PDO::PARAM_STR);
			$stmt->bindParam(':box_dinar',$box_dinar,PDO::PARAM_STR);
			$stmt->bindParam(':box_tman',$box_tman,PDO::PARAM_STR);
			$stmt->execute();
			
			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			$jTableResult['Record'] = self::last_row_data();
			self::record('write','Write data to '.self::$TABLE,"DATA : owner_name = {$data['a_dollar']} / detail = {$data['detail']}");
			return json_encode($jTableResult);
		}
		catch(PDOException $e){
			echo 'Error: [fund.class.php/function create]'.$e->getMessage().'<br>';
			die();
		}
	}

	public static function update_box($id_user,$id,$offset_dollar,$offset_dinar,$offset_tman){
		try{
			$sql = "UPDATE ".self::$TABLE." SET box_dollar = box_dollar + (:offset_dollar), box_dinar = box_dinar + (:offset_dinar), box_tman = box_tman + (:offset_tman) WHERE id >= :id";
			// dsh($sql);
			// var_dump($id_user,$id,$offset_dollar,$offset_dinar,$offset_tman);
			$stmt = self::$PDO->prepare($sql);
			$stmt->bindParam(':offset_dollar',$offset_dollar,PDO::PARAM_INT);
			$stmt->bindParam(':offset_dinar',$offset_dinar,PDO::PARAM_INT);
			$stmt->bindParam(':offset_tman',$offset_tman,PDO::PARAM_INT);
			// $stmt->bindParam(':id_user',$id_user,PDO::PARAM_INT);
			$stmt->bindParam(':id',$id,PDO::PARAM_INT);
			$stmt->execute();
			return true;
		}
		catch(PDOException $e){
			echo 'Error: [fund.class.php/function update_box]'.$e->getMessage().'<br>';
			die();
		}
	}



	public static function update($data){
		try{

			$before = self::get_fund_info($data['id']);

			$sql = "UPDATE ".self::$TABLE." SET `id_user` = :id_user, `a_dollar` = :a_dollar, `a_dinar` = :a_dinar, `a_tman` = :a_tman, `detail` = :detail WHERE id = :id";
			$stmt = self::$PDO->prepare($sql);
			
			$stmt->bindParam(':id_user',$data['id_user'],PDO::PARAM_STR);
			// $stmt->bindParam(':date_time',$data['date_time'],PDO::PARAM_STR);
			// $stmt->bindParam(':type',$data['type'],PDO::PARAM_STR);
			// $stmt->bindParam(':id_f',$data['id_f'],PDO::PARAM_STR);
			$stmt->bindParam(':a_dollar',$data['a_dollar'],PDO::PARAM_STR);
			$stmt->bindParam(':a_dinar',$data['a_dinar'],PDO::PARAM_STR);
			$stmt->bindParam(':a_tman',$data['a_tman'],PDO::PARAM_STR);
			$stmt->bindParam(':detail',$data['detail'],PDO::PARAM_STR);
			$stmt->bindParam(':id',$data['id'],PDO::PARAM_INT);
			$stmt->execute();

			$offset_dollar = $data['a_dollar'] - $before['a_dollar'];
			$offset_dinar = $data['a_dinar'] - $before['a_dinar'];
			$offset_tman = $data['a_tman'] - $before['a_tman'];
			self::update_box(0,$data['id'],$offset_dollar,$offset_dinar,$offset_tman);
			
			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			self::record('write','Edit data in '.self::$TABLE,"DATA : name = owner_name = {$data['a_dollar']} / detail = {$data['detail']} / id = {$data['id']} ");
			return json_encode($jTableResult);
		}
		catch(PDOException $e){
			echo 'Error: [fund.class.php/function update]'.$e->getMessage().'<br>';
			die();
		}
	}

	public static function delete($id){
		try{
			$before = self::get_fund_info($id);



			$sql = "DELETE FROM ".self::$TABLE." WHERE id = :id";
			$stmt = self::$PDO->prepare($sql);
			$stmt->bindParam(':id',$id,PDO::PARAM_INT);
			$stmt->execute();

			$offset_dollar = 0 - $before['a_dollar'];
			$offset_dinar = 0 - $before['a_dinar'];
			$offset_tman = 0 - $before['a_tman'];
			self::update_box(0,$id,$offset_dollar,$offset_dinar,$offset_tman);

			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			self::record('write','WARNING : Delete data in '.self::$TABLE.' but havent permission',"DATA : id = $id");
			return json_encode($jTableResult);
			break;
		}
		catch(PDOException $e){
			echo 'Error: [fund.class.php/function delete]'.$e->getMessage().'<br>';
			die();
		}
	}

	public static function json_list($part){
		try{
			$sql = "SELECT id AS Value,account_number AS DisplayText FROM ".self::$TABLE ;
			$result = self::$PDO->query($sql);
			$rows = $result->fetchAll(PDO::FETCH_ASSOC);

			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			$jTableResult['Options'] = $rows;
			return json_encode($jTableResult);
		}
		catch(PDOException $e){
			echo 'Error: [department.class.php/function json_list]'.$e->getMessage().'<br>';
			die();
		}
	}

	public static function get_fund_info($id){
		try{
			$sql = "SELECT * FROM ".self::$TABLE." WHERE id = :id";
			$stmt = self::$PDO->prepare($sql);
			$stmt->bindParam(':id',$id,PDO::PARAM_INT);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			return $row;
		}
		catch(PDOException $e){
			echo 'Error: [fund.class.php/function get_fund_info]'.$e->getMessage().'<br>';
			die();
		}
	}

	public static function get_fund_info2($type,$id){
		try{
			$sql = "SELECT * FROM ".self::$TABLE." WHERE `type` = :type AND `id_f` = :id";
			// dsh($sql);
			$stmt = self::$PDO->prepare($sql);
			$stmt->bindParam(':id',$id,PDO::PARAM_INT);
			$stmt->bindParam(':type',$type,PDO::PARAM_STR);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			return $row;
		}
		catch(PDOException $e){
			echo 'Error: [fund.class.php/function get_fund_info]'.$e->getMessage().'<br>';
			die();
		}
	}
}

// $fund = new fund();

// dsh(fund::lists('id ASC',0,10));


// $data = array(
// 	'type' => 'expense',
//     'a_dollar' => '6000',
//     'a_dinar' => '',
//     'a_tman' => '',
//     'detail' => 'ewqeew',
//     'id' => 47);
// dsh(fund::update($data));
// $data = array(
//     'a_dollar' => '650',
//     'detail' => '');
// dsh(fund::create($data));
?>