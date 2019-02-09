<?php
session_start();
error_reporting(E_ALL);
function dsh($v){
	echo '<pre style="color:red">';
	ob_start();
	var_dump($v);
	$result = ob_get_clean();
	$result = str_replace(">\n", '>', $result);
	echo $result;
	echo '</pre>';
}

class database{
	public $pdo;
	public static $PDO;
	function __construct(){
		try {
	    $this->pdo = new PDO('mysql:host=localhost;dbname=bank', 'root', '');
	    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    $this->pdo->query('SET NAMES utf8');

	    /*static mode*/
	    self::$PDO = $this->pdo;
		} 
		catch (PDOException $e) {
		    print "Error!: " . $e->getMessage() . "<br/>";
		    die();
		}
	}

	public static function hack_pageSize($startIndex,$pageSize){
		$startIndex = intval($startIndex);
		$pageSize = intval($pageSize);
		if(!$pageSize)
			die('Hack Detection!');/* use admin log for security issue !!! database*/
	}

	public static function hack_sorting($sorting){
		$sorting = str_replace("'", "", $sorting);
		$sorting = str_replace('"', '"', $sorting);
		return $sorting;
	}

	private static function check_column_exist($column,$table){
		try{
			$sql = "SHOW COLUMNS FROM `$table` LIKE '$column'";
			$result = self::$PDO->query($sql);
			$rows = $result->fetchAll(PDO::FETCH_ASSOC);
			if($rows)
				return true;
			return NULL;
		}
		catch(PDOException $e){
			return null;
		}
		
	}

	

//for jtable
	public static function calculate_rows($table){
		try{
			$sql = "SELECT count(id) AS count FROM $table";
			$result = self::$PDO->query($sql);
			$count = $result->fetchObject();
			return $count->count;
		}
		catch(PDOException $e){
			echo 'Error: [database.class.php/function calculate_row]'.$e->getMessage().'<br>';
			die();
		}
	}

	public static function last_id_data($table){
		try{
			$sql = "SELECT * FROM $table ORDER BY id DESC LIMIT 1";
			$stmt = self::$PDO->query($sql);
			$row = $stmt->fetchObject();
			return $row;
		}
		catch(PDOException $e){
			echo 'Error: [database.class.php/function last_id_data]'.$e->getMessage().'<br>';
			die();
		}
	}

}

$db = new database();

?>