<?php
require_once 'database.class.php';

class reports extends database{
	private static $TABLE = 'accounts';

	public static function calculate_row(){
		try{
			$sql = "SELECT count(id) AS count FROM ".self::$TABLE;
			$result = self::$PDO->query($sql);
			$count = $result->fetchObject();
			return $count->count;
		}
		catch(PDOException $e){
			echo 'Error: [reports.class.php/function calculate_row]'.$e->getMessage().'<br>';
			die();
		}
	}


	public static function lists($sorting,$startIndex,$pageSize,$year = null){
		try{
			self::hack_pageSize($startIndex,$pageSize);
			$sorting = self::hack_sorting($sorting);
			$pageSize *=5;
			/*$sql = "SELECT * FROM ".self::$TABLE." ORDER BY $sorting LIMIT $startIndex, $pageSize;";*/
			$sql = "SELECT *,sum(amount) AS total_payment FROM `payments` WHERE YEAR(date) = $year GROUP BY id_account, MONTH(date) ORDER BY $sorting  LIMIT $startIndex, $pageSize;";
			$result = self::$PDO->query($sql);
			$rows = $result->fetchAll(PDO::FETCH_ASSOC);
			$count = count($rows);
			$arr_accounts = array(); 
			$total = array();
			for($i=0;$i<$count;$i++){
				$timestamp = strtotime($rows[$i]['date']);
				$month = date('M',$timestamp);
				$arr_accounts[$rows[$i]['id_account']][$month] = $rows[$i]['total_payment'];
				@$arr_accounts[$rows[$i]['id_account']]['total'] += $rows[$i]['total_payment'];
				//$arr_accounts
				$rows[$i]['date'] = $month;
				@$total[$month] += $rows[$i]['total_payment'];
				//@$rows[$i]['balance'] = self::calculate_balance($rows[$i]['id']);
			}
			$total['total'] = 'total';
			$arr_final = array();
			$n = array();
			foreach ($arr_accounts as $key => $value) {
				$value['id_account'] = $key;
				array_push($arr_final, $value);
			}
			//return $arr_final;
			$arr_final[count($arr_final)] = $total;

			//return $rows;
			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			$jTableResult['TotalRecordCount'] = count($arr_final);
			$jTableResult['Records'] = $arr_final;
			self::record('read','View Reports');
			return json_encode($jTableResult);
		}
		catch(PDOException $e){
			echo 'Error: [reports.class.php/function lists]'.$e->getMessage().'<br>';
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
			echo 'Error: [reports.class.php/function last_row_data]'.$e->getMessage().'<br>';
			die();
		}
	}

	public static function create($data){
		try{
			$sql = "INSERT INTO ".self::$TABLE."(owner_name,account_number,balance,date_created,detail) VALUES(:owner_name,:account_number,:balance,NOW(),:detail);";
			$stmt = self::$PDO->prepare($sql);
			$stmt->bindParam(':owner_name',$data['owner_name'],PDO::PARAM_STR);
			$stmt->bindParam(':account_number',$data['account_number'],PDO::PARAM_STR);
			$stmt->bindParam(':balance',$data['balance'],PDO::PARAM_STR);
			$stmt->bindParam(':detail',$data['detail'],PDO::PARAM_STR);
			$stmt->execute();
			
			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			$jTableResult['Record'] = self::last_row_data();
			self::record('write','Write data to '.self::$TABLE,"DATA : owner_name = {$data['owner_name']} / detail = {$data['detail']}");
			return json_encode($jTableResult);
		}
		catch(PDOException $e){
			echo 'Error: [reports.class.php/function create]'.$e->getMessage().'<br>';
			die();
		}
	}

	public static function update($data){
		try{
			$sql = "UPDATE ".self::$TABLE." SET owner_name = :owner_name, account_number = :account_number, balance = :balance, detail = :detail WHERE id = :id";
			$stmt = self::$PDO->prepare($sql);
			$stmt->bindParam(':owner_name',$data['owner_name'],PDO::PARAM_STR);
			$stmt->bindParam(':account_number',$data['account_number'],PDO::PARAM_STR);
			$stmt->bindParam(':balance',$data['balance'],PDO::PARAM_STR);
			$stmt->bindParam(':detail',$data['detail'],PDO::PARAM_STR);
			$stmt->bindParam(':id',$data['id'],PDO::PARAM_INT);
			$stmt->execute();
			
			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			self::record('write','Edit data in '.self::$TABLE,"DATA : name = owner_name = {$data['owner_name']} / detail = {$data['detail']} / id = {$data['id']} ");
			return json_encode($jTableResult);
		}
		catch(PDOException $e){
			echo 'Error: [reports.class.php/function update]'.$e->getMessage().'<br>';
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
			break;
		}
		catch(PDOException $e){
			echo 'Error: [reports.class.php/function delete]'.$e->getMessage().'<br>';
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

	public static function get_reports_info($id){
		try{
			$sql = "SELECT * FROM ".self::$TABLE." WHERE id = :id";
			$stmt = self::$PDO->prepare($sql);
			$stmt->bindParam(':id',$id,PDO::PARAM_INT);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			return $row;
		}
		catch(PDOException $e){
			echo 'Error: [reports.class.php/function get_reports_info]'.$e->getMessage().'<br>';
			die();
		}
	}
}

//$reports = new reports();
/**/
//dsh(reports::lists('id_account ASC',0,10,2013));


?>