<?php
require_once 'database.class.php';
require_once 'fund.class.php';
require_once 'accounts.class.php';

class loan_payout extends database{
	private static $TABLE = 'loan_payout';

	public static function calculate_row(){
		try{
			$sql = "SELECT count(id) AS count FROM ".self::$TABLE;
			$result = self::$PDO->query($sql);
			$count = $result->fetchObject();
			return $count->count;
		}
		catch(PDOException $e){
			echo 'Error: [loan_payout.class.php/function calculate_row]'.$e->getMessage().'<br>';
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
			echo 'Error: [loan_payout.class.php/function calculate_balance]'.$e->getMessage().'<br>';
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
				@$rows[$i]['a_tman'] = dsh_money($rows[$i]['a_tman']);
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
			echo 'Error: [loan_payout.class.php/function lists]'.$e->getMessage().'<br>';
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
			echo 'Error: [loan_payout.class.php/function last_row_data]'.$e->getMessage().'<br>';
			die();
		}
	}

	public static function create($data){
		try{
			
			//file_put_contents('a.txt',print_r($data,true));
			$sql = "INSERT INTO ".self::$TABLE."(`id_user`, `id_account`, `date_time`, `a_dollar`, `a_dinar`, `a_tman`, `detail`, `loss`) VALUES (:id_user,:id_account,NOW(),:a_dollar,:a_dinar,:a_tman,:detail,:loss);";

			if(!isset($data['date_time']))
				$data['date_time'] = date('Y-m-d H:i:i:s');

			$stmt = self::$PDO->prepare($sql);
			$stmt->bindParam(':id_user',$data['id_user'],PDO::PARAM_STR);
			$stmt->bindParam(':id_account',$data['id_account'],PDO::PARAM_STR);
			//$stmt->bindParam(':date_time',$data['date_time'],PDO::PARAM_STR);
			$stmt->bindParam(':a_dollar',$data['a_dollar'],PDO::PARAM_STR);
			$stmt->bindParam(':a_dinar',$data['a_dinar'],PDO::PARAM_STR);
			$stmt->bindParam(':a_tman',$data['a_tman'],PDO::PARAM_STR);
			$stmt->bindParam(':detail',$data['detail'],PDO::PARAM_STR);
			$stmt->bindParam(':loss',$data['loss'],PDO::PARAM_INT);
			$stmt->execute();
			$last_record = self::last_row_data();

			$accounts_info = accounts::get_accounts_info($data['id_account']);

			$data_fund = array(
							'type' => 'loan_payout',
							'a_dollar' => -$data['a_dollar'],
							'a_dinar' => -$data['a_dinar'],
							'a_tman' => -$data['a_tman'],
							'detail' => $accounts_info['owner_name'],
							'date_time' => $data['date_time'],
							'id_f' => $last_record->id
						);
			if(@$data['loss']){
				$data_fund['detail'] .= ' - '.dic_return('profit').' / '.$data_fund['a_dollar'];
				$data_fund['a_dollar'] = 0;
			}
			fund::create($data_fund);
			
			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			$jTableResult['Record'] = $last_record;
			self::record('write','Write data to '.self::$TABLE,"DATA : a_dollar = {$data['a_dollar']} / detail = {$data['detail']}");
			return json_encode($jTableResult);
		}
		catch(PDOException $e){
			echo 'Error: [loan_payout.class.php/function create]'.$e->getMessage().'<br>';
			die();
		}
	}

	public static function update($data){
		try{

			$sql = "UPDATE ".self::$TABLE." SET `id_user` = :id_user, `id_account` = :id_account, `a_dollar` = :a_dollar, `a_dinar` = :a_dinar, `a_tman` = :a_tman, `detail` = :detail, `loss` = :loss  WHERE id = :id";
			$stmt = self::$PDO->prepare($sql);
			$stmt->bindParam(':id_user',$data['id_user'],PDO::PARAM_STR);
			$stmt->bindParam(':id_account',$data['id_account'],PDO::PARAM_STR);
			// $stmt->bindParam(':date_time',$data['date_time'],PDO::PARAM_STR);
			$stmt->bindParam(':a_dollar',$data['a_dollar'],PDO::PARAM_STR);
			$stmt->bindParam(':a_dinar',$data['a_dinar'],PDO::PARAM_STR);
			$stmt->bindParam(':a_tman',$data['a_tman'],PDO::PARAM_STR);
			$stmt->bindParam(':detail',$data['detail'],PDO::PARAM_STR);
			$stmt->bindParam(':loss',$data['loss'],PDO::PARAM_INT);
			$stmt->bindParam(':id',$data['id'],PDO::PARAM_INT);
			$stmt->execute();

			$fund_info = fund::get_fund_info2('loan_payout',$data['id']);
			$accounts_info = accounts::get_accounts_info($data['id_account']);
			// dsh($fund_info);
			$data_fund = array(
							'type' => 'loan_payout',
							'a_dollar' => -$data['a_dollar'],
							'a_dinar' => -$data['a_dinar'],
							'a_tman' => -$data['a_tman'],
							'detail' => $accounts_info['owner_name'],
							// 'date_time' => $data['date_time'],
							'id' => $fund_info['id']
						);
			if(@$data['loss']){
				$data_fund['detail'] .= ' - '.dic_return('profit').' / '.$data_fund['a_dollar'];
				$data_fund['a_dollar'] = 0;
			}
			fund::update($data_fund);
			
			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			self::record('write','Edit data in '.self::$TABLE,"DATA : name = owner_name = {$data['a_dollar']} / detail = {$data['detail']} / id = {$data['id']} ");
			return json_encode($jTableResult);
		}
		catch(PDOException $e){
			echo 'Error: [loan_payout.class.php/function update]'.$e->getMessage().'<br>';
			die();
		}
	}

	public static function delete($id){
		try{
			$sql = "DELETE FROM ".self::$TABLE." WHERE id = :id";
			$stmt = self::$PDO->prepare($sql);

			$stmt->bindParam(':id',$id,PDO::PARAM_INT);
			$stmt->execute();

			$fund_info = fund::get_fund_info2('loan_payout',$id);
			// dsh($fund_info);
			fund::delete($fund_info['id']);

			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			self::record('write','WARNING : Delete data in '.self::$TABLE.' but havent permission',"DATA : id = $id");
			return json_encode($jTableResult);
			break;
		}
		catch(PDOException $e){
			echo 'Error: [loan_payout.class.php/function delete]'.$e->getMessage().'<br>';
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

	public static function get_loan_payout_info($id){
		try{
			$sql = "SELECT * FROM ".self::$TABLE." WHERE id = :id";
			$stmt = self::$PDO->prepare($sql);
			$stmt->bindParam(':id',$id,PDO::PARAM_INT);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			return $row;
		}
		catch(PDOException $e){
			echo 'Error: [loan_payout.class.php/function get_loan_payout_info]'.$e->getMessage().'<br>';
			die();
		}
	}
}

// $loan_payout = new loan_payout();

// dsh(loan_payout::lists('id ASC',0,10));


// $data = array(
//         'id_account' => '3',
// 	    'a_dollar' => '350',
// 	    'a_dinar' => '350000',
// 	    'a_tman' => '1000000',
// 	    'detail' => '36325',
// 	    'id' => 47
// );
// dsh(loan_payout::update($data));
// dsh(loan_payout::create($data));
// dsh(loan_payout::delete(55));
?>
