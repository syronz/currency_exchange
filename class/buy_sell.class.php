<?php
require_once 'database.class.php';

class buy_sell extends database{
	private static $TABLE = 'buy_sell';

	public static function calculate_row(){
		try{
			$sql = "SELECT count(id) AS count FROM ".self::$TABLE;
			$result = self::$PDO->query($sql);
			$count = $result->fetchObject();
			return $count->count;
		}
		catch(PDOException $e){
			echo 'Error: [buy_sell.class.php/function calculate_row]'.$e->getMessage().'<br>';
			die();
		}
	}

	public static function lists($sorting,$startIndex,$pageSize){
		try{
			self::hack_pageSize($startIndex,$pageSize);
			$sorting = self::hack_sorting($sorting);
			$sql = "SELECT * FROM ".self::$TABLE." ORDER BY $sorting LIMIT $startIndex, $pageSize;";
			$result = self::$PDO->query($sql);
			$rows = $result->fetchAll(PDO::FETCH_ASSOC);

			$count = count($rows);
			for($i=0;$i<$count;$i++){
				@$rows[$i]['total_buying'] = dsh_money($rows[$i]['total_buy']);
				@$rows[$i]['total_selling'] = dsh_money($rows[$i]['total_sell']);
				@$rows[$i]['amount'] = dsh_money($rows[$i]['amount']);
				@$rows[$i]['buy_rate'] = dsh_money($rows[$i]['buy_rate']);
				@$rows[$i]['sell_rate'] = dsh_money($rows[$i]['sell_rate']);
			}
			
			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			$jTableResult['TotalRecordCount'] = self::calculate_row();
			$jTableResult['Records'] = $rows;
			self::record('read','View '.self::$TABLE.' Table');
			return json_encode($jTableResult);
		}
		catch(PDOException $e){
			echo 'Error: [buy_sell.class.php/function lists]'.$e->getMessage().'<br>';
			die();
		}
	}
	
	public static function list_today($sorting,$startIndex,$pageSize){
		try{
			self::hack_pageSize($startIndex,$pageSize);
			$sorting = self::hack_sorting($sorting);
			$sql = "SELECT * FROM ".self::$TABLE." WHERE date_time > CURDATE() AND date_time < (CURDATE()+1) ORDER BY $sorting LIMIT $startIndex, $pageSize;";
			$result = self::$PDO->query($sql);
			$rows = $result->fetchAll(PDO::FETCH_ASSOC);

			$count = count($rows);
			for($i=0;$i<$count;$i++){
				// @$rows[$i]['total_buying'] = dsh_money($rows[$i]['amount'] / $rows[$i]['buy_rate'],'',0);
				// @$rows[$i]['total_selling'] = dsh_money($rows[$i]['amount'] / $rows[$i]['buy_rate'] * $rows[$i]['sell_rate'] / $rows[$i]['buy_rate'],'',0);
				@$rows[$i]['total_buying'] = dsh_money($rows[$i]['total_buy']);
				@$rows[$i]['total_selling'] = dsh_money($rows[$i]['total_sell']);
				@$rows[$i]['amount'] = dsh_money($rows[$i]['amount']);
				@$rows[$i]['buy_rate'] = dsh_money($rows[$i]['buy_rate']);
				@$rows[$i]['sell_rate'] = dsh_money($rows[$i]['sell_rate']);
			}
			
			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			$jTableResult['TotalRecordCount'] = self::calculate_row();
			$jTableResult['Records'] = $rows;
			self::record('read','View '.self::$TABLE.' Table');
			return json_encode($jTableResult);
		}
		catch(PDOException $e){
			echo 'Error: [buy_sell.class.php/function lists]'.$e->getMessage().'<br>';
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
			echo 'Error: [buy_sell.class.php/function last_row_data]'.$e->getMessage().'<br>';
			die();
		}
	}

	public static function create($data){
		try{
			// file_put_contents('a.txt', print_r($data,true));
			$sql = "INSERT INTO ".self::$TABLE."(id_user,id_account_buy,id_account_sell,amount,buy_rate,sell_rate,total_buy,total_sell,date_time,detail_buy,detail_sell) VALUES(:id_user,:id_account_buy,:id_account_sell,:amount,:buy_rate,:sell_rate,:total_buy,:total_sell,NOW(),:detail_buy,:detail_sell);";
			$data['date_time'] = date('Y-m-d H:i:s',time());
			if($data['type'] == 1){
				$total_buy = $data['amount'] / $data['buy_rate'];
				// $total_sell = $total_buy * $data['sell_rate'] / $data['buy_rate'];
				$total_sell = $data['amount'] / $data['sell_rate'];
				// file_put_contents('a.txt', $total_sell);
			}
			else if($data['type'] == 2){
				$total_buy = $data['amount'] * $data['buy_rate'];
				$total_sell = $total_buy * $data['sell_rate'] / $data['buy_rate'];
			}
			else if($data['type'] == 3){
				$total_buy = $data['amount'] ;
				$total_sell = $data['amount'];
			}
			else if($data['type'] == 4){
				$total_buy = $data['amount'] ;
				$total_sell = $data['amount'] * $data['sell_rate'] / $data['buy_rate'];
			}
			

			$stmt = self::$PDO->prepare($sql);
			$stmt->bindParam(':id_user',$data['id_user'],PDO::PARAM_STR);
			$stmt->bindParam(':id_account_buy',$data['id_account_buy'],PDO::PARAM_STR);
			$stmt->bindParam(':id_account_sell',$data['id_account_sell'],PDO::PARAM_STR);
			$stmt->bindParam(':amount',$data['amount'],PDO::PARAM_STR);
			$stmt->bindParam(':buy_rate',$data['buy_rate'],PDO::PARAM_STR);
			$stmt->bindParam(':sell_rate',$data['sell_rate'],PDO::PARAM_STR);
			$stmt->bindParam(':total_buy',$total_buy,PDO::PARAM_STR);
			$stmt->bindParam(':total_sell',$total_sell,PDO::PARAM_STR);
			// $stmt->bindParam(':date_time',$data['date_time'],PDO::PARAM_STR);
			$stmt->bindParam(':detail_buy',$data['detail_buy'],PDO::PARAM_STR);
			$stmt->bindParam(':detail_sell',$data['detail_sell'],PDO::PARAM_STR);
			$stmt->execute();

			// {"id":"16","id_user":null,"id_account_buy":"1","id_account_sell":"2","amount":"6,050","buy_rate":"55","sell_rate":"63","total_buy":"110","total_sell":"126","date_time":"2014-05-03 10:26:56","detail_buy":"222","detail_sell":"655","total_buying":"110","total_selling":"126"}

			// {"id":"12","id_user":null,"id_account_buy":"1","id_account_sell":"2","amount":"40000","buy_rate":"350","sell_rate":"351","total_buy":"9","total_sell":"11461","date_time":"2014-05-03 10:17:19","detail_buy":"ds","detail_sell":"sad"}
			
			/*$sql = "UPDATE accounts SET balance = balance + :amount";
			$stmt = self::$PDO->prepare($sql);
			$stmt->bindParam(':amount',$data['amount'],PDO::PARAM_STR);
			$stmt->execute();*/ 
			
			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			$jTableResult['Record'] = self::last_row_data();
			// self::record('write','Write data to '.self::$TABLE,"DATA : id_account = {$data['id_account_buy']} / amount = {$data['amount']}");
			return json_encode($jTableResult);
		}
		catch(PDOException $e){
			echo 'Error: [buy_sell.class.php/function create]'.$e->getMessage().'<br>';
			die();
		}
	}

	public static function update($data){
		try{
			$sql = "UPDATE ".self::$TABLE." SET id_user = :id_user ,id_account_buy = :id_account_buy,id_account_sell = :id_account_sell,amount = :amount,buy_rate = :buy_rate,sell_rate = :sell_rate,total_buy = :total_buy,total_sell = :total_sell,date_time = :date_time,detail_buy = :detail_buy,detail_sell = :detail_sell WHERE id = :id";
			$stmt = self::$PDO->prepare($sql);
			$data['date_time'] = date('Y-m-d H:i:s',time());
			$total_buy = $data['amount'] / $data['buy_rate'];
			$total_sell = $total_buy * $data['sell_rate'] / $data['buy_rate'];
			$stmt = self::$PDO->prepare($sql);
			$stmt->bindParam(':id_user',$data['id_user'],PDO::PARAM_STR);
			$stmt->bindParam(':id_account_buy',$data['id_account_buy'],PDO::PARAM_STR);
			$stmt->bindParam(':id_account_sell',$data['id_account_sell'],PDO::PARAM_STR);
			$stmt->bindParam(':amount',$data['amount'],PDO::PARAM_STR);
			$stmt->bindParam(':buy_rate',$data['buy_rate'],PDO::PARAM_STR);
			$stmt->bindParam(':sell_rate',$data['sell_rate'],PDO::PARAM_STR);
			$stmt->bindParam(':total_buy',$total_buy,PDO::PARAM_STR);
			$stmt->bindParam(':total_sell',$total_sell,PDO::PARAM_STR);
			$stmt->bindParam(':date_time',$data['date_time'],PDO::PARAM_STR);
			$stmt->bindParam(':detail_buy',$data['detail_buy'],PDO::PARAM_STR);
			$stmt->bindParam(':detail_sell',$data['detail_sell'],PDO::PARAM_STR);
			$stmt->bindParam(':id',$data['id'],PDO::PARAM_INT);
			$stmt->execute();
			
			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			self::record('write','Edit data in '.self::$TABLE,"DATA : id_account = {$data['id_account_buy']} / amount = {$data['amount']} / id = {$data['id']} ");
			return json_encode($jTableResult);
		}
		catch(PDOException $e){
			echo 'Error: [buy_sell.class.php/function update]'.$e->getMessage().'<br>';
			die();
		}
	}

	public static function delete($id){
		try{
			$sql = "DELETE FROM ".self::$TABLE." WHERE id = :id";
			$stmt = self::$PDO->prepare($sql);
			$stmt->bindParam(':id',$_POST['id'],PDO::PARAM_INT);
			$stmt->execute();

			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			self::record('write','WARNING : Delete data in '.self::$TABLE.' but havent permission',"DATA : id = $id");
			return json_encode($jTableResult);
		}
		catch(PDOException $e){
			echo 'Error: [buy_sell.class.php/function delete]'.$e->getMessage().'<br>';
			die();
		}
	}

	public static function json_list($id_department,$part){
		try{
			$where = self::return_user_range($part);
			$id_department = intval($id_department);
			if($id_department)
				$sql = "SELECT id AS Value,name AS DisplayText FROM ".self::$TABLE." WHERE id_department = $id_department AND {$where['buy_sell']}";
			else
				$sql = "SELECT id AS Value,name AS DisplayText FROM ".self::$TABLE;
			$result = self::$PDO->query($sql);
			$rows = $result->fetchAll(PDO::FETCH_ASSOC);

			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			$jTableResult['Options'] = $rows;
			return json_encode($jTableResult);
		}
		catch(PDOException $e){
			echo 'Error: [buy_sell.class.php/function json_list]'.$e->getMessage().'<br>';
			die();
		}
	}

	public static function get_payments_info($id){
		try{
			$sql = "SELECT * FROM ".self::$TABLE." WHERE id = :id";
			$stmt = self::$PDO->prepare($sql);
			$stmt->bindParam(':id',$id,PDO::PARAM_INT);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			return $row;
		}
		catch(PDOException $e){
			echo 'Error: [buy_sell.class.php/function get_payments_info]'.$e->getMessage().'<br>';
			die();
		}
	}
}

//$payments = new buy_sell();

//var_dump($payments->show_paymentss('id',0,5));

// $data = array("id_account_buy" => "1",
//     "amount" => "4000000",
//     "buy_rate" => "350",
//     "detail_buy" => "ds",
//     "id_account_sell" => "2",
//     "sell_rate" => "351",
//     "detail_sell" => "sad");
// dsh(buy_sell::create($data));


?>