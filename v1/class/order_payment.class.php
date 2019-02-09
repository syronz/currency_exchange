<?php
require_once 'database.class.php';
require_once 'fund.class.php';
require_once 'accounts.class.php';

class order_payment extends database{
	private static $TABLE = 'order_payment';

	public static function calculate_row(){
		try{
			$sql = "SELECT count(id) AS count FROM ".self::$TABLE;
			$result = self::$PDO->query($sql);
			$count = $result->fetchObject();
			return $count->count;
		}
		catch(PDOException $e){
			echo 'Error: [order_payment.class.php/function calculate_row]'.$e->getMessage().'<br>';
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
			echo 'Error: [order_payment.class.php/function calculate_balance]'.$e->getMessage().'<br>';
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
				// @$rows[$i]['a_dollar'] = dsh_money($rows[$i]['a_dollar']);
				// @$rows[$i]['a_dinar'] = dsh_money($rows[$i]['a_dinar']);
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
			echo 'Error: [order_payment.class.php/function lists]'.$e->getMessage().'<br>';
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
			echo 'Error: [order_payment.class.php/function last_row_data]'.$e->getMessage().'<br>';
			die();
		}
	}

	public static function create($data){
		try{
			file_put_contents('a.txt', print_r($data,true));
			// INSERT INTO `exchange`.`order_payment` (`id`, `id_user`, `date_time`, `a_dollar`, `a_dinar`, `a_tman`,  `detail`) VALUES (NULL, '1', '2014-04-10 00:00:00', '500', NULL, NULL, 'diako', '07505149171', '', NULL, NULL, NULL, 'good');
			$sql = "INSERT INTO ".self::$TABLE."(`id_user`,`id_account`, `date_time`, `a_dollar`, `a_dinar`, `a_tman`,`cost`,`sender_name`, `sender_phone`, `reciever_name`, `reciever_phone`, `reciever_address`, `state`, `detail`) VALUES (:id_user,:id_account,NOW(),:a_dollar,:a_dinar,:a_tman,:cost,:sender_name,:sender_phone,:reciever_name,:reciever_phone,:reciever_address,:state,:detail);";

			if(!isset($data['date_time']))
				$data['date_time'] = date('Y-m-d H:i:i:s');

			$stmt = self::$PDO->prepare($sql);
			$stmt->bindParam(':id_user',$data['id_user'],PDO::PARAM_STR);
			$stmt->bindParam(':id_account',$data['id_account'],PDO::PARAM_STR);
			// $stmt->bindParam(':date_time',$data['date_time'],PDO::PARAM_STR);
			$stmt->bindParam(':a_dollar',$data['a_dollar'],PDO::PARAM_STR);
			$stmt->bindParam(':a_dinar',$data['a_dinar'],PDO::PARAM_STR);
			$stmt->bindParam(':a_tman',$data['a_tman'],PDO::PARAM_STR);
			$stmt->bindParam(':cost',$data['cost'],PDO::PARAM_STR);
			$stmt->bindParam(':sender_name',$data['sender_name'],PDO::PARAM_STR);
			$stmt->bindParam(':sender_phone',$data['sender_phone'],PDO::PARAM_STR);
			$stmt->bindParam(':reciever_name',$data['reciever_name'],PDO::PARAM_STR);
			$stmt->bindParam(':reciever_phone',$data['reciever_phone'],PDO::PARAM_STR);
			$stmt->bindParam(':reciever_address',$data['reciever_address'],PDO::PARAM_STR);
			$stmt->bindParam(':state',$data[''],PDO::PARAM_STR);

			$stmt->bindParam(':detail',$data['detail'],PDO::PARAM_STR);
			$stmt->execute();
			$last_record = self::last_row_data();


			$data_fund = array(
							'type' => 'order_payment',
							'a_dollar' => $data['a_dollar']+$data['cost'],
							'a_dinar' => $data['a_dinar'],
							'a_tman' => $data['a_tman'],
							'detail' => $data['sender_name'].' -> '.$data['reciever_name'].' / '.$data['reciever_address'],
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
			echo 'Error: [order_payment.class.php/function create]'.$e->getMessage().'<br>';
			die();
		}
	}

	public static function update($data){
		try{

			// $sql = "UPDATE ".self::$TABLE." SET `id_user` = :id_user, `id_account` = :id_account, `a_dollar` = :a_dollar, `a_dinar` = :a_dinar, `a_tman` = :a_tman,`sender_name` = :sender_name, `sender_phone` = :sender_phone, `reciever_name` = :reciever_name, `reciever_phone` = :reciever_phone, `reciever_address` = :reciever_address, `state` = :state, `detail` = :detail  WHERE id = :id";
			$sql = "UPDATE ".self::$TABLE." SET `id_user` = :id_user, `id_account` = :id_account, `a_dollar` = :a_dollar, `a_dinar` = :a_dinar, `a_tman` = :a_tman,`cost` = :cost,`sender_name` = :sender_name, `sender_phone` = :sender_phone, `reciever_name` = :reciever_name, `reciever_phone` = :reciever_phone, `reciever_address` = :reciever_address, `state` = :state, `detail` = :detail  WHERE id = :id";
			$stmt = self::$PDO->prepare($sql);
			$stmt->bindParam(':id_user',$data['id_user'],PDO::PARAM_STR);
			$stmt->bindParam(':id_account',$data['id_account'],PDO::PARAM_STR);
			// $stmt->bindParam(':date_time',$data['date_time'],PDO::PARAM_STR);
			$stmt->bindParam(':a_dollar',$data['a_dollar'],PDO::PARAM_STR);
			$stmt->bindParam(':a_dinar',$data['a_dinar'],PDO::PARAM_STR);
			$stmt->bindParam(':a_tman',$data['a_tman'],PDO::PARAM_STR);
			$stmt->bindParam(':cost',$data['cost'],PDO::PARAM_STR);
			$stmt->bindParam(':sender_name',$data['sender_name'],PDO::PARAM_STR);
			$stmt->bindParam(':sender_phone',$data['sender_phone'],PDO::PARAM_STR);
			$stmt->bindParam(':reciever_name',$data['reciever_name'],PDO::PARAM_STR);
			$stmt->bindParam(':reciever_phone',$data['reciever_phone'],PDO::PARAM_STR);
			$stmt->bindParam(':reciever_address',$data['reciever_address'],PDO::PARAM_STR);
			$stmt->bindParam(':state',$data['state'],PDO::PARAM_STR);
			$stmt->bindParam(':detail',$data['detail'],PDO::PARAM_STR);
			$stmt->bindParam(':id',$data['id'],PDO::PARAM_INT);
			$stmt->execute();

			$fund_info = fund::get_fund_info2('order_payment',$data['id']);
			// $accounts_info = accounts::get_accounts_info($data['id_account']);
			// dsh($fund_info);
			$data_fund = array(
							'type' => 'order_payment',
							'a_dollar' => $data['a_dollar']+$data['cost'],
							'a_dinar' => $data['a_dinar'],
							'a_tman' => $data['a_tman'],
							'detail' => $data['sender_name'].' -> '.$data['reciever_name'].' / '.$data['reciever_address'],
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
			echo 'Error: [order_payment.class.php/function update]'.$e->getMessage().'<br>';
			die();
		}
	}

	public static function delete($id){
		try{
			$sql = "DELETE FROM ".self::$TABLE." WHERE id = :id";
			$stmt = self::$PDO->prepare($sql);

			$stmt->bindParam(':id',$id,PDO::PARAM_INT);
			$stmt->execute();

			$fund_info = fund::get_fund_info2('order_payment',$id);
			// dsh($fund_info);
			fund::delete($fund_info['id']);

			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			self::record('write','WARNING : Delete data in '.self::$TABLE.' but havent permission',"DATA : id = $id");
			return json_encode($jTableResult);
			break;
		}
		catch(PDOException $e){
			echo 'Error: [order_payment.class.php/function delete]'.$e->getMessage().'<br>';
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

	public static function get_order_payment_info($id){
		try{
			$sql = "SELECT * FROM ".self::$TABLE." WHERE id = :id";
			$stmt = self::$PDO->prepare($sql);
			$stmt->bindParam(':id',$id,PDO::PARAM_INT);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			return $row;
		}
		catch(PDOException $e){
			echo 'Error: [order_payment.class.php/function get_order_payment_info]'.$e->getMessage().'<br>';
			die();
		}
	}




	/***************************** PSULA **********************************/
	public static function psula_lists($sorting,$startIndex,$pageSize){
		try{
			self::hack_pageSize($startIndex,$pageSize);
			$sorting = self::hack_sorting($sorting);
			$sql = "SELECT * FROM psula ORDER BY $sorting LIMIT $startIndex, $pageSize;";
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
			echo 'Error: [order_payment.class.php/function psula_lists]'.$e->getMessage().'<br>';
			die();
		}
	}

	public static function psula_create($data){
		try{
			file_put_contents('a.txt', print_r($data,true));
			$sql = "INSERT INTO psula(`date_time`, `amount`,`sender`, `reciever`, `type`, `detail`) VALUES (NOW(),:amount,:sender,:reciever,:type,:detail);";
			// INSERT INTO `exchange`.`psula` (`id`, `date_time`, `type`, `reciever`, `sender`, `amount`, `detail`) VALUES (NULL, '2014-05-08 00:00:00', '$', 'dsfgfd', 'gdfgdfg', '222222', 'fdgdfgfgdf');

			if(!isset($data['date_time']))
				$data['date_time'] = date('Y-m-d H:i:i:s');

			$stmt = self::$PDO->prepare($sql);
			$stmt->bindParam(':amount',$data['amount'],PDO::PARAM_STR);
			$stmt->bindParam(':sender',$data['sender'],PDO::PARAM_STR);
			$stmt->bindParam(':reciever',$data['reciever'],PDO::PARAM_STR);
			$stmt->bindParam(':type',$data['type'],PDO::PARAM_STR);
			$stmt->bindParam(':detail',$data['detail'],PDO::PARAM_STR);
			$stmt->execute();
			$last_record = self::last_row_data();

			$sql = "SELECT * FROM psula WHERE id=LAST_INSERT_ID();";
			$stmt = self::$PDO->query($sql);
			$last_record = $stmt->fetchObject();


			
			
			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			$jTableResult['Record'] = $last_record;
			self::record('write','Write data to psula DATA : amount = ');
			return json_encode($jTableResult);
		}
		catch(PDOException $e){
			echo 'Error: [order_payment.class.php/function psula_create]'.$e->getMessage().'<br>';
			die();
		}
	}

	public static function psula_update($data){
		try{
			file_put_contents('a.txt', print_r($data,true));
			$sql = "UPDATE psula SET  `amount` = :amount, `sender` = :sender, `reciever` = :reciever, `type` = :type, `detail` = :detail WHERE `id` = :id;";


			$stmt = self::$PDO->prepare($sql);
			$stmt->bindParam(':amount',$data['amount'],PDO::PARAM_STR);
			$stmt->bindParam(':sender',$data['sender'],PDO::PARAM_STR);
			$stmt->bindParam(':reciever',$data['reciever'],PDO::PARAM_STR);
			$stmt->bindParam(':type',$data['type'],PDO::PARAM_STR);
			$stmt->bindParam(':detail',$data['detail'],PDO::PARAM_STR);
			$stmt->bindParam(':id',$data['id'],PDO::PARAM_STR);
			$stmt->execute();
			
			
			$jTableResult = array();
			$jTableResult['Result'] = "OK";

			self::record('write','Write data to psula DATA : amount = ');
			return json_encode($jTableResult);
		}
		catch(PDOException $e){
			echo 'Error: [order_payment.class.php/function psula_update]'.$e->getMessage().'<br>';
			die();
		}
	}

	public static function psula_delete($id){
		try{
			$sql = "DELETE FROM psula WHERE id = :id";
			$stmt = self::$PDO->prepare($sql);

			$stmt->bindParam(':id',$id,PDO::PARAM_INT);
			$stmt->execute();


			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			self::record('write','WARNING : Delete data ');
			return json_encode($jTableResult);
			break;
		}
		catch(PDOException $e){
			echo 'Error: [order_payment.class.php/function psula_delete]'.$e->getMessage().'<br>';
			die();
		}
	}

	public static function get_psula_payment_info($id){
		try{
			$sql = "SELECT * FROM psula WHERE id = :id";
			$stmt = self::$PDO->prepare($sql);
			$stmt->bindParam(':id',$id,PDO::PARAM_INT);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			return $row;
		}
		catch(PDOException $e){
			echo 'Error: [order_payment.class.php/function get_order_payment_info]'.$e->getMessage().'<br>';
			die();
		}
	}
}

// $order_payment = new order_payment();

// dsh(order_payment::lists('id ASC',0,10));


 // $data = array(
 //         'a_dollar' => '500',
 // 	    'a_dinar' => '300',
 // 	    'a_tman' => '200',
	// 'id_account' => '1',
 // 	    'sender_name' => 'diako amir',
 // 	    'sender_phone' => '07505149171',
 // 	    'reciever_name' => 'ako sharifi',
 // 	    'reciever_phone' => '09357533638',
 // 	    'reciever_address' => 'bokan',
 // 	    'detail' => 'test',
 // 	    'id' => 2
 // );
 //dsh(order_payment::update($data));
 // dsh(order_payment::create($data));
// dsh(order_payment::delete(55));
// $data = array('id' => '2',
// 	'amount' =>'34324',
//     'type' => 'tman',
//     'sender' =>' 32432',
//     'reciever' =>'32423',
//     'detail' => '24234');
// //  dsh(order_payment::psula_create($data))
//  dsh(order_payment::psula_update($data))


// $data = array('id_account' => '2',
//     'a_dollar' => '30000',
//     'cost' => '10',
//     'sender_name' => 'walid',
//     'sender_phone' => '34234',
//     'reciever_name' => 'aso',
//     'reciever_phone' => '',
//     'reciever_address' => '',
//     'detail' => 'walid nardi bo aso'
//     );
// dsh(order_payment::create($data));
?>
