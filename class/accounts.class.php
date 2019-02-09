<?php
require_once 'database.class.php';

class accounts extends database{
	private static $TABLE = 'accounts';

	public static function calculate_row(){
		try{
			$sql = "SELECT count(id) AS count FROM ".self::$TABLE;
			$result = self::$PDO->query($sql);
			$count = $result->fetchObject();
			return $count->count;
		}
		catch(PDOException $e){
			echo 'Error: [accounts.class.php/function calculate_row]'.$e->getMessage().'<br>';
			die();
		}
	}

	public static function calculate_balance($id_account){
		try{
			$sql = "SELECT SUM(amount) AS total_payments FROM payments WHERE id_account = '$id_account'";
			$result = self::$PDO->query($sql);
			$row = $result->fetch(PDO::FETCH_ASSOC);
			$total_payments = $row['total_payments'];

			$sql = "SELECT SUM(amount) AS total_payouts FROM payouts WHERE id_account = '$id_account'";
			$result = self::$PDO->query($sql);
			$row = $result->fetch(PDO::FETCH_ASSOC);
			$total_payouts = $row['total_payouts'];
			
			
			$sql = "SELECT SUM(total_buy) AS total_buy FROM buy_sell WHERE id_account_buy = '$id_account'";
			$result = self::$PDO->query($sql);
			$row = $result->fetch(PDO::FETCH_ASSOC);
			$total_buy = $row['total_buy'];
			
			$sql = "SELECT SUM(total_sell) AS total_sell FROM buy_sell WHERE id_account_sell = '$id_account'";
			$result = self::$PDO->query($sql);
			$row = $result->fetch(PDO::FETCH_ASSOC);
			$total_sell = $row['total_sell'];
			

			return ($total_payments - $total_payouts + $total_buy - $total_sell);
		}
		catch(PDOException $e){
			echo 'Error: [accounts.class.php/function calculate_balance]'.$e->getMessage().'<br>';
			die();
		}
	}

	private static function calculate_b_dollar($id_account){
		try{
			$sql = "SELECT SUM(a_dollar) AS total_payments FROM loan_payment WHERE id_account = '$id_account'";
			$result = self::$PDO->query($sql);
			$row = $result->fetch(PDO::FETCH_ASSOC);
			$total_dollar_payments = $row['total_payments'];

			$sql = "SELECT SUM(a_dollar) AS total_payouts FROM loan_payout WHERE id_account = '$id_account'";
			$result = self::$PDO->query($sql);
			$row = $result->fetch(PDO::FETCH_ASSOC);
			$total_dollar_payouts = $row['total_payouts'];
			
			
			$sql = "SELECT SUM(total_buy) AS total_buy FROM buy_sell WHERE id_account_buy = '$id_account'";
			$result = self::$PDO->query($sql);
			$row = $result->fetch(PDO::FETCH_ASSOC);
			$total_buy = $row['total_buy'];
			
			$sql = "SELECT SUM(total_sell) AS total_sell FROM buy_sell WHERE id_account_sell = '$id_account'";
			$result = self::$PDO->query($sql);
			$row = $result->fetch(PDO::FETCH_ASSOC);
			$total_sell = $row['total_sell'];
			
			
			$sql = "SELECT SUM(a_dollar) AS total_order_payment FROM order_payment WHERE id_account = '$id_account'";
			$result = self::$PDO->query($sql);
			$row = $result->fetch(PDO::FETCH_ASSOC);
			$total_order_payment = $row['total_order_payment'];
			
			$sql = "SELECT SUM(a_dollar) AS total_order_payouts FROM order_payout WHERE id_account = '$id_account'";
			$result = self::$PDO->query($sql);
			$row = $result->fetch(PDO::FETCH_ASSOC);
			$total_order_payouts = $row['total_order_payouts'];/**/

			return ($total_dollar_payments - $total_dollar_payouts + $total_buy - $total_sell + $total_order_payment - $total_order_payouts);
		}
		catch(PDOException $e){
			echo 'Error: [accounts.class.php/function calculate_b_dollar]'.$e->getMessage().'<br>';
			die();
		}
	}

	private static function calculate_b_dollar_time($id_account,$time){
		try{
			$sql = "SELECT SUM(a_dollar) AS total_payments FROM loan_payment WHERE id_account = '$id_account' AND date_time < '$time'";
			$result = self::$PDO->query($sql);
			$row = $result->fetch(PDO::FETCH_ASSOC);
			$total_dollar_payments = $row['total_payments'];

			$sql = "SELECT SUM(a_dollar) AS total_payouts FROM loan_payout WHERE id_account = '$id_account' AND date_time < '$time'";
			$result = self::$PDO->query($sql);
			$row = $result->fetch(PDO::FETCH_ASSOC);
			$total_dollar_payouts = $row['total_payouts'];

			$sql = "SELECT SUM(a_dollar) AS total_payments FROM order_payment WHERE id_account = '$id_account' AND date_time < '$time'";
			$result = self::$PDO->query($sql);
			$row = $result->fetch(PDO::FETCH_ASSOC);
			$total_order_payments = $row['total_payments'];

			$sql = "SELECT SUM(a_dollar) AS total_payouts FROM order_payout WHERE id_account = '$id_account' AND date_time < '$time'";
			$result = self::$PDO->query($sql);
			$row = $result->fetch(PDO::FETCH_ASSOC);
			$total_order_payouts = $row['total_payouts'];

			$sql = "SELECT SUM(total_buy) AS total_payments FROM buy_sell WHERE id_account_buy = '$id_account' AND date_time < '$time'";
			$result = self::$PDO->query($sql);
			$row = $result->fetch(PDO::FETCH_ASSOC);
			$total_buy = $row['total_payments'];

			$sql = "SELECT SUM(total_sell) AS total_payments FROM buy_sell WHERE id_account_sell = '$id_account' AND date_time < '$time'";
			$result = self::$PDO->query($sql);
			$row = $result->fetch(PDO::FETCH_ASSOC);
			$total_sell = $row['total_payments'];

			return ($total_dollar_payments - $total_dollar_payouts + $total_order_payments - $total_order_payouts + $total_buy - $total_sell);
		}
		catch(PDOException $e){
			echo 'Error: [accounts.class.php/function calculate_b_dollar_time]'.$e->getMessage().'<br>';
			die();
		}
	}

	private static function calculate_b_dinar($id_account){
		try{
			$sql = "SELECT SUM(a_dinar) AS total_payments FROM loan_payment WHERE id_account = '$id_account'";
			$result = self::$PDO->query($sql);
			$row = $result->fetch(PDO::FETCH_ASSOC);
			$total_dinar_payments = $row['total_payments'];

			$sql = "SELECT SUM(a_dinar) AS total_payouts FROM loan_payout WHERE id_account = '$id_account'";
			$result = self::$PDO->query($sql);
			$row = $result->fetch(PDO::FETCH_ASSOC);
			$total_dinar_payouts = $row['total_payouts'];

			return ($total_dinar_payments - $total_dinar_payouts);
		}
		catch(PDOException $e){
			echo 'Error: [accounts.class.php/function calculate_b_dinar]'.$e->getMessage().'<br>';
			die();
		}
	}

	private static function calculate_b_tman($id_account){
		try{
			$sql = "SELECT SUM(a_tman) AS total_payments FROM loan_payment WHERE id_account = '$id_account'";
			$result = self::$PDO->query($sql);
			$row = $result->fetch(PDO::FETCH_ASSOC);
			$total_tman_payments = $row['total_payments'];

			$sql = "SELECT SUM(a_tman) AS total_payouts FROM loan_payout WHERE id_account = '$id_account'";
			$result = self::$PDO->query($sql);
			$row = $result->fetch(PDO::FETCH_ASSOC);
			$total_tman_payouts = $row['total_payouts'];

			return ($total_tman_payments - $total_tman_payouts);
		}
		catch(PDOException $e){
			echo 'Error: [accounts.class.php/function calculate_b_tman]'.$e->getMessage().'<br>';
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
				@$rows[$i]['balance'] = self::calculate_balance($rows[$i]['id']);
				@$rows[$i]['b_dollar'] = dsh_money(-self::calculate_b_dollar($rows[$i]['id']));
				@$rows[$i]['b_dinar'] = dsh_money(self::calculate_b_dinar($rows[$i]['id']));
				@$rows[$i]['b_tman'] = dsh_money(self::calculate_b_tman($rows[$i]['id']));
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
			echo 'Error: [accounts.class.php/function lists]'.$e->getMessage().'<br>';
			die();
		}
	}

	public static function list_report($sorting,$startIndex,$pageSize,$date){
		try{
			self::hack_pageSize($startIndex,$pageSize);
			$sorting = self::hack_sorting($sorting);
			$sql = "SELECT * FROM ".self::$TABLE." ORDER BY id ";
			$result = self::$PDO->query($sql);
			$rows = $result->fetchAll(PDO::FETCH_ASSOC);
			$count = count($rows);

			$date1 = strtotime($date);
			//$date1 -= 86400;
			$date1 = date('Y-m-d',$date1);
			
			
			$real_date = strtotime($date);
			$real_date += 86400;
			$date = date('Y-m-d',$real_date);

			$result_final = array();
			$i_p = 1;
			$i_m = 1;
			$total_p = 0;
			$total_m = 0;
			
			$sql = "SELECT box_dollar FROM `fund` WHERE date_time < '$date' ORDER BY id DESC LIMIT 1";
			// dsh($sql);
			$result = self::$PDO->query($sql);
			$row = $result->fetchObject();
			if(isset($row->box_dollar))
				$resid = $row->box_dollar;
			else
				$resid = 0;
			//dsh($sql);
			$result_final[$i_m]['id'] = $i_m;
			$result_final[$i_m]['name_m'] = 'رسيد';
			$result_final[$i_m]['amount_m'] = dsh_money($resid);
			$result_final[$i_m]['space'] = '';
			@$total_m += intval(-$resid);
			$i_m++;
			
			
			foreach ($rows as $key => $value) {
				$balance = self::calculate_b_dollar_time($value['id'],$date);
				if($balance >= 0){
					if($balance != 0){
						$result_final[$i_p]['id'] = $i_p;
						$result_final[$i_p]['name_p'] = $value['owner_name'];
						$result_final[$i_p]['amount_p'] = dsh_money($balance);
						$result_final[$i_p]['space'] = '';
						@$total_p += $balance;
						$i_p++;
					}
					
				}
				else{
					$result_final[$i_m]['id'] = $i_m;
					$result_final[$i_m]['name_m'] = $value['owner_name'];
					$result_final[$i_m]['amount_m'] = dsh_money(abs($balance));
					$result_final[$i_m]['space'] = '';
					@$total_m += $balance;
					$i_m++;
				}
			}
// dsh($result_final);
			$max_id = $i_p;

			if($i_m > $max_id)
				$max_id = $i_m;
			$result_final[$max_id]['id'] = $max_id;
			$max_id++;
			$result_final[$max_id]['id'] = $max_id;
			$result_final[$max_id]['name_p'] = 'مجموع';
			$result_final[$max_id]['name_m'] = 'مجموع';
			$result_final[$max_id]['amount_p'] = dsh_money($total_p);
			$result_final[$max_id]['amount_m'] = dsh_money(abs($total_m));
			
			$max_id++;
			$result_final[$max_id]['id'] = $max_id;
			$result_final[$max_id]['name_p'] = 'ئه نجام';
			$result_final[$max_id]['name_m'] = '';
			$result_final[$max_id]['amount_p'] = dsh_money(-($total_p + $total_m));
			$result_final[$max_id]['amount_m'] = '';

			// for($i=0;$i<$count;$i++){
			// 	@$rows[$i]['balance'] = self::calculate_balance($rows[$i]['id']);
			// 	@$rows[$i]['b_dollar'] = dsh_money(self::calculate_b_dollar($rows[$i]['id']));
			// 	@$rows[$i]['b_dinar'] = dsh_money(self::calculate_b_dinar($rows[$i]['id']));
			// 	@$rows[$i]['b_tman'] = dsh_money(self::calculate_b_tman($rows[$i]['id']));
			// }

			//return $rows;
			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			$jTableResult['TotalRecordCount'] = self::calculate_row();
			$jTableResult['Records'] = $result_final;
			self::record('read','View '.self::$TABLE.' Table');
			return json_encode($jTableResult);
		}
		catch(PDOException $e){
			echo 'Error: [accounts.class.php/function lists]'.$e->getMessage().'<br>';
			die();
		}
	}

	public static function account_report_date($sorting,$startIndex,$pageSize,$start_date,$end_date,$id_account){
		try{
			
			/*$end_date = strtotime($end_date);
			$end_date += 86400;
			$end_date = date('Y-m-d',$end_date);*/
			
			$sql = "SELECT SUM(a_dollar) AS sum_payment FROM loan_payment  WHERE id_account = '$id_account' AND date_time < '$start_date' ";
			$result = self::$PDO->query($sql);
			$row = $result->fetchObject();
			$sum_payment = $row->sum_payment;

			$sql = "SELECT SUM(a_dollar) AS sum_payout FROM loan_payout  WHERE id_account = '$id_account' AND date_time < '$start_date' ";
			$result = self::$PDO->query($sql);
			$row = $result->fetchObject();
			$sum_payout = $row->sum_payout;

			$sql = "SELECT SUM(a_dollar) AS sum_payment FROM order_payment  WHERE id_account = '$id_account' AND date_time < '$start_date' ";
			$result = self::$PDO->query($sql);
			$row = $result->fetchObject();
			$sum_payment_order = $row->sum_payment;

			$sql = "SELECT SUM(a_dollar) AS sum_payout FROM order_payout  WHERE id_account = '$id_account' AND date_time < '$start_date' ";
			$result = self::$PDO->query($sql);
			$row = $result->fetchObject();
			$sum_payout_order = $row->sum_payout;

			$sql = "SELECT SUM(total_buy) AS sum_total_buy FROM buy_sell  WHERE id_account_buy = '$id_account' AND date_time < '$start_date' ";
			$result = self::$PDO->query($sql);
			$row = $result->fetchObject();
			$sum_total_buy = $row->sum_total_buy;

			$sql = "SELECT SUM(total_sell) AS sum_total_sell FROM buy_sell  WHERE id_account_sell = '$id_account' AND date_time < '$start_date' ";
			$result = self::$PDO->query($sql);
			$row = $result->fetchObject();
			$sum_total_sell = $row->sum_total_sell;





			$sum_balance = $sum_payout - $sum_payment + $sum_payout_order - $sum_payment_order + $sum_total_sell - $sum_total_buy;
			// dsh($sum_balance,$sum_payout , $sum_payment,$sum_payout_order , $sum_payment_order,$sum_total_sell , $sum_total_buy,$id_account);

			$end_date = strtotime($end_date);
			$end_date += 86400;
			$end_date = date('Y-m-d',$end_date);
			
			$rows1p = array();
			$rows2p = array();
			$rows3p = array();


			$sql = "SELECT detail,date_time,a_dollar AS p_dollar,null AS m_dollar FROM `loan_payment` WHERE id_account = '$id_account' AND date_time >= '$start_date' AND date_time < '$end_date'  UNION select detail,date_time,null AS p_dollar,a_dollar AS m_dollar from loan_payout WHERE id_account = '$id_account' AND date_time >= '$start_date' AND date_time < '$end_date'  ORDER BY date_time";
			$result = self::$PDO->query($sql);
			$rows1 = $result->fetchAll(PDO::FETCH_ASSOC);
			$count = count($rows1);
			for($i=0;$i<$count;$i++){
				if($rows1[$i]['p_dollar'] > $rows1[$i]['m_dollar'])
					$rows1[$i]['type'] = 'loan_payment';
				else
					$rows1[$i]['type'] = 'loan_payout';
				//$rows1p[strtotime($rows1[$i]['date_time'])] = $rows1[$i];
			}
			
			$sql = "SELECT detail,date_time,a_dollar AS p_dollar,null AS m_dollar FROM `order_payment` WHERE id_account = '$id_account' AND date_time >= '$start_date' AND date_time < '$end_date'  UNION select detail,date_time,null AS p_dollar,a_dollar AS m_dollar from order_payout WHERE id_account = '$id_account' AND date_time >= '$start_date' AND date_time < '$end_date'  ORDER BY date_time";
			$result = self::$PDO->query($sql);
			$rows2 = $result->fetchAll(PDO::FETCH_ASSOC);
			$count = count($rows2);
			for($i=0;$i<$count;$i++){
				if($rows2[$i]['p_dollar'] > $rows2[$i]['m_dollar'])
					$rows2[$i]['type'] = 'order_payment';
				else
					$rows2[$i]['type'] = 'order_payout';
				//$rows2p[strtotime($rows2[$i]['date_time'])] = $rows2[$i];
			}

			$sql = "SELECT detail_buy AS detail,date_time,total_buy AS p_dollar,null AS m_dollar FROM `buy_sell` WHERE id_account_buy = '$id_account' AND date_time >= '$start_date' AND date_time < '$end_date'  UNION select detail_sell AS detail,date_time,null AS p_dollar,total_sell AS m_dollar from buy_sell WHERE id_account_sell = '$id_account' AND date_time >= '$start_date' AND date_time < '$end_date'  ORDER BY date_time";
			$result = self::$PDO->query($sql);
			$rows3 = $result->fetchAll(PDO::FETCH_ASSOC);
			$count = count($rows3);
			for($i=0;$i<$count;$i++){
				if($rows3[$i]['p_dollar'] > $rows3[$i]['m_dollar'])
					$rows3[$i]['type'] = 'buy';
				else
					$rows3[$i]['type'] = 'sell';
				//$rows3p[strtotime($rows3[$i]['date_time'])] = $rows3[$i];
			}
			
			//dsh($rows3);
			
			$result = array_merge($rows1,$rows2,$rows3);
//dsh($result);
			/*$result[0]['balance'] = $sum_balance;
			$count = count($result);
			for($i=0;$i<$count;$i++){
				$result[$i]['id'] = $i+1;
				$sum_balance = $sum_balance - $result[$i]['p_dollar'] + $result[$i]['m_dollar'];
				@$result[$i]['balance'] = $sum_balance;
			}*/

			// $a = array(2=>'two_1',3=>'three');
			// dsh(array_key_exists(2, $a));

			foreach($result as $key => $value){
				// dsh(strtotime($value['date_time']));
				// dsh(array_key_exists(strtotime($value['date_time']), $rows1p));
				if(!array_key_exists(strtotime($value['date_time']), $rows1p))
					$rows1p[strtotime($value['date_time'])] = $value;
				else{
					$n = strtotime($value['date_time']);
					while(array_key_exists($n, $rows1p)){
						$n++;
						// echo ($n);
					}

					$rows1p[$n] = $value;
				}
				$rows2p[$value['date_time']] = $value;
			}

			
			ksort($rows1p);
			// dsh($rows1p);
			$i = 1;
			foreach($rows1p as $key => &$value){
				@$value['id'] = $i++;
				
				$sum_balance = $sum_balance - $value['p_dollar'] + $value['m_dollar'];
				@$value['p_dollar'] = dsh_money($value['p_dollar']);
				@$value['m_dollar'] = dsh_money($value['m_dollar']);
				@$value['balance'] = dsh_money($sum_balance);
			}
			
			$arr_final = array();
			foreach($rows1p as $key => &$value){
				array_push($arr_final,$value);
			}
			
			
			//dsh($rows1p);
//dsh($arr_final);

			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			$jTableResult['TotalRecordCount'] = $count;
			$jTableResult['Records'] = $arr_final;
			self::record('read','View '.self::$TABLE.' Table');
			return json_encode($jTableResult);
		}
		catch(PDOException $e){
			echo 'Error: [accounts.class.php/function account_report_date]'.$e->getMessage().'<br>';
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
			echo 'Error: [accounts.class.php/function last_row_data]'.$e->getMessage().'<br>';
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
			$last_row = self::last_row_data();
			$jTableResult['Record'] = $last_row;
			self::record('write','Write data to '.self::$TABLE,"DATA : owner_name = {$data['owner_name']} / detail = {$data['detail']}");
			return json_encode($jTableResult);
		}
		catch(PDOException $e){
			echo 'Error: [accounts.class.php/function create]'.$e->getMessage().'<br>';
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
			echo 'Error: [accounts.class.php/function update]'.$e->getMessage().'<br>';
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
			echo 'Error: [accounts.class.php/function delete]'.$e->getMessage().'<br>';
			die();
		}
	}

	public static function json_list($part){
		try{
			$sql = "SELECT id AS Value,owner_name AS DisplayText FROM ".self::$TABLE." ORDER BY owner_name" ;
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

	public static function get_accounts_info($id){
		try{
			$sql = "SELECT * FROM ".self::$TABLE." WHERE id = :id";
			$stmt = self::$PDO->prepare($sql);
			$stmt->bindParam(':id',$id,PDO::PARAM_INT);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			return $row;
		}
		catch(PDOException $e){
			echo 'Error: [accounts.class.php/function get_accounts_info]'.$e->getMessage().'<br>';
			die();
		}
	}
}

// $accounts = new accounts();

// dsh(accounts::lists('id ASC',0,10));


// $data = array(
// 	'account_number' => 'wdrew',
//     'owner_name' => 'wewe',
//     'detail' => 'wewe');
// dsh(accounts::create($data));
//dsh(accounts::calculate_balance(1));
?>
