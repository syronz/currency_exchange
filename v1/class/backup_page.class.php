<?php
	require_once 'database.class.php'; 
	class backup_page extends database{
		// private static $TABLE = 'backup_page';
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
				echo 'Error: [backup_page.class.php/function record]'.$e->getMessage().'<br>';
				die();
			}
		}

		public static function lists($sorting=null,$startIndex=null,$pageSize=null){
		try{

			$directory = '../backups/';
			$arr_backups = array();
			$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
			$i = 1;
			while($it->valid()) {
			    if (!$it->isDot()) {
			        // echo 'SubPathName: ' . $it->getSubPathName() . "<br>";
			        // echo 'SubPath:     ' . $it->getSubPath() . "<br>";
			        // echo 'Key:         ' . $it->key() . "<br><br>";
			        $field = array('id'=>$i,
			        	'name'=>$it->getSubPathName(),
			        	'restore'=>'<a href="restore.php?file_name='.$it->getSubPathName().'">Restore Link</a>',
			        	'target'=>$it->key());
			        array_unshift($arr_backups,$field);
			        $i++;
			    }

			    $it->next();
			}
			if($sorting == 'id ASC')
				$arr_backups = array_reverse($arr_backups);
			// array
// dsh($arr_backups);
			$count = count($arr_backups);
			$rows = array();
			for($i=0; $i<$count; $i++){
				if($i >= $startIndex && $i < ($startIndex + $pageSize))
					array_unshift($rows,$arr_backups[$i]);
			}
			$rows = array_reverse($rows);
	// dsh($rows);		
			// self::hack_pageSize($startIndex,$pageSize);
			// $sorting = self::hack_sorting($sorting);
			// $sql = "SELECT * FROM ".self::$TABLE." ORDER BY $sorting LIMIT $startIndex, $pageSize;";
			// $result = self::$PDO->query($sql);
			// $rows = $result->fetchAll(PDO::FETCH_ASSOC);

			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			$jTableResult['TotalRecordCount'] = $count;
			$jTableResult['Records'] = $rows;
			// self::record('read','View All User Activity');
			return json_encode($jTableResult);
		}
		catch(PDOException $e){
			echo 'Error: [backup_page.class.php/function lists]'.$e->getMessage().'<br>';
			die();
		}
	}
	}

//backup_page::record_activity('write',5,'ddd','no');
// backup_page::lists(0,0,2);
		
?>