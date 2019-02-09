<?php
require_once 'database.class.php';
require_once 'fund.class.php';

class expense extends database{
	private static $TABLE = 'expense';

	public static function calculate_row(){
		try{
			$sql = "SELECT count(id) AS count FROM ".self::$TABLE;
			$result = self::$PDO->query($sql);
			$count = $result->fetchObject();
			return $count->count;
		}
		catch(PDOException $e){
			echo 'Error: [expense.class.php/function calculate_row]'.$e->getMessage().'<br>';
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
			echo 'Error: [expense.class.php/function calculate_balance]'.$e->getMessage().'<br>';
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
				@$rows[$i]['a_dollar'] = dsh_money($rows[$i]['a_dollar']);
				@$rows[$i]['a_dinar'] = dsh_money($rows[$i]['a_dinar']);
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
			echo 'Error: [expense.class.php/function lists]'.$e->getMessage().'<br>';
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
			echo 'Error: [expense.class.php/function last_row_data]'.$e->getMessage().'<br>';
			die();
		}
	}

	public static function create($data){
		try{
			
			// INSERT INTO `exchange`.`expense` (`id`, `id_user`, `date_time`, `a_dollar`, `a_dinar`, `description`, `detail`) VALUES (NULL, '1', '2014-04-10 00:00:00', '200', '50000', 'sigaret', 'kak bawar');
			$sql = "INSERT INTO ".self::$TABLE."(`id_user`, `date_time`, `a_dollar`, `a_dinar`, `description`, `detail`) VALUES (:id_user,:date_time,:a_dollar,:a_dinar,:description,:detail);";

			if(!isset($data['date_time']))
				$data['date_time'] = date('Y-m-d H:i:i:s');
			$id_user = 5;
			$stmt = self::$PDO->prepare($sql);
			$stmt->bindParam(':id_user',$id_user,PDO::PARAM_STR);
			$stmt->bindParam(':date_time',$data['date_time'],PDO::PARAM_STR);
			$stmt->bindParam(':a_dollar',$data['a_dollar'],PDO::PARAM_STR);
			$stmt->bindParam(':a_dinar',$data['a_dinar'],PDO::PARAM_STR);
			$stmt->bindParam(':description',$data['description'],PDO::PARAM_STR);
			$stmt->bindParam(':detail',$data['detail'],PDO::PARAM_STR);
			$stmt->execute();
			$last_record = self::last_row_data();

			$data_fund = array(
							'type' => 'expense',
							'a_dollar' => -$data['a_dollar'],
							'a_dinar' => -$data['a_dinar'],
							'a_tman' => 0,
							'detail' => $data['description'],
							'date_time' => $data['date_time'],
							'id_f' => $last_record->id
						);
			fund::create($data_fund);
			
			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			$jTableResult['Record'] = $last_record;
			self::record('write','Write data to '.self::$TABLE,"DATA : a_dollar = {$data['a_dollar']} / detail = {$data['detail']}");
			return json_encode($jTableResult);
		}
		catch(PDOException $e){
			echo 'Error: [expense.class.php/function create]'.$e->getMessage().'<br>';
			die();
		}
	}

	public static function update($data){
		try{

			$sql = "UPDATE ".self::$TABLE." SET `id_user` = :id_user, `a_dollar` = :a_dollar, `a_dinar` = :a_dinar, `description` = :description, `detail` = :detail  WHERE id = :id";
			$stmt = self::$PDO->prepare($sql);
			$stmt->bindParam(':id_user',$data['id_user'],PDO::PARAM_STR);
			// $stmt->bindParam(':date_time',$data['date_time'],PDO::PARAM_STR);
			$stmt->bindParam(':a_dollar',$data['a_dollar'],PDO::PARAM_STR);
			$stmt->bindParam(':a_dinar',$data['a_dinar'],PDO::PARAM_STR);
			$stmt->bindParam(':description',$data['description'],PDO::PARAM_STR);
			$stmt->bindParam(':detail',$data['detail'],PDO::PARAM_STR);
			$stmt->bindParam(':id',$data['id'],PDO::PARAM_INT);
			$stmt->execute();

			$fund_info = fund::get_fund_info2('expense',$data['id']);
			// dsh($fund_info);
			$data_fund = array(
							'type' => 'expense',
							'a_dollar' => -$data['a_dollar'],
							'a_dinar' => -$data['a_dinar'],
							'a_tman' => 0,
							'detail' => $data['description'],
							// 'date_time' => $data['date_time'],
							'id' => $fund_info['id']
						);
			fund::update($data_fund);
			
			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			self::record('write','Edit data in '.self::$TABLE,"DATA : name = owner_name = {$data['a_dollar']} / detail = {$data['detail']} / id = {$data['id']} ");
			return json_encode($jTableResult);
		}
		catch(PDOException $e){
			echo 'Error: [expense.class.php/function update]'.$e->getMessage().'<br>';
			die();
		}
	}

	public static function delete($id){
		try{
			$sql = "DELETE FROM ".self::$TABLE." WHERE id = :id";
			$stmt = self::$PDO->prepare($sql);

			$stmt->bindParam(':id',$id,PDO::PARAM_INT);
			$stmt->execute();

			$fund_info = fund::get_fund_info2('expense',$id);
			// dsh($fund_info);
			fund::delete($fund_info['id']);

			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			self::record('write','WARNING : Delete data in '.self::$TABLE.' but havent permission',"DATA : id = $id");
			return json_encode($jTableResult);
		}
		catch(PDOException $e){
			echo 'Error: [expense.class.php/function delete]'.$e->getMessage().'<br>';
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

	public static function get_expense_info($id){
		try{
			$sql = "SELECT * FROM ".self::$TABLE." WHERE id = :id";
			$stmt = self::$PDO->prepare($sql);
			$stmt->bindParam(':id',$id,PDO::PARAM_INT);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			return $row;
		}
		catch(PDOException $e){
			echo 'Error: [expense.class.php/function get_expense_info]'.$e->getMessage().'<br>';
			die();
		}
	}
}

// $expense = new expense();

// dsh(expense::lists('id ASC',0,10));


// $data = array(
// 	    'a_dollar' => '300',
// 	    'a_dinar' => '0',
// 	    'description' => 'diako',
// 	    'detail' => '0',
// 	    'id' => 47
// );
// // dsh(expense::update($data));
// dsh(expense::create($data));
// dsh(expense::delete(55));
?>