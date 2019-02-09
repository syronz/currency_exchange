<?php
	require_once 'database.class.php'; 
	class user_activity extends database{
		private static $TABLE = 'user_activity';
		public static function record_activity($ip,$id_user,$action,$detail=null){
			try{
				$sql = "INSERT INTO ".self::$TABLE."(ip,id_user,action,detail,date) VALUES(:ip,:id_user,:action,:detail,NOW());";
				$stmt = self::$PDO->prepare($sql);
				$stmt->bindParam(':ip',$ip,PDO::PARAM_STR);
				$stmt->bindParam(':id_user',$id_user,PDO::PARAM_STR);
				$stmt->bindParam(':action',$action,PDO::PARAM_STR);
				$stmt->bindParam(':detail',$detail,PDO::PARAM_STR);
				$stmt->execute();
				return true;
			}
			catch(PDOException $e){
				echo 'Error: [user_activity.class.php/function record]'.$e->getMessage().'<br>';
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

			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			$jTableResult['TotalRecordCount'] = self::calculate_rows(self::$TABLE);
			$jTableResult['Records'] = $rows;
			self::record('read','View All User Activity');
			return json_encode($jTableResult);
		}
		catch(PDOException $e){
			echo 'Error: [user_activity.class.php/function lists]'.$e->getMessage().'<br>';
			die();
		}
	}
	}

//user_activity::record_activity('write',5,'ddd','no');
		
?>