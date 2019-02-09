<?php
session_start();
error_reporting(E_ALL);
if(!isset($_SESSION['id_user']))
    header('location:login.php');

date_default_timezone_set("Asia/Baghdad");
require_once 'dictionary.ku.class.php';
require_once 'setting.class.php';
require_once 'user_activity.class.php';
function dsh(){
    $argList = func_get_args();
    // var_dump($argList);
    foreach($argList as $key => $v){
        echo '<pre style="color:red">';
        ob_start();
        var_dump($v);
        $result = ob_get_clean();
        $result = str_replace(">\n", '>', $result);
        echo $result;
        echo '</pre><hr>';
    }
}


function dsh_money($money,$decimal_check = 2,$symbol = null){
	if($money == 0)
		return 0;
	$negative = false;
	if($money < 0){
		$negative = true;
		$money = abs($money);
	}
	$decimal = $money - intval($money);
	$arr = array();
	if($money !== 0)
		while($money){
			$part = strval($money % 1000);
			$len = strlen($part);
			if($len == 1)
				$part = '00'.$part;
			else if($len == 2)
				$part = '0'.$part;
			$money =intval($money/1000);
			array_push($arr, $part);
		}
	else
		$arr = array(0);
	$arr = array_reverse($arr);
	
	$str = implode(',', $arr);
	if(strlen($str)>1){
		if($str[0]=='0')
			$str = substr($str, 1);
		if($str[0]=='0')
			$str = substr($str, 1);
	}
	
	if($decimal_check)
		if(round($decimal,$decimal_check))
			$str .= substr(strval(round($decimal,2)),1);
	if($symbol)
		$str .= ' '.$symbol;

	if($negative)
		$str = '-'.$str;
	return $str;
}

function money_to_word($number) 
{
/*****
     * A recursive function to turn digits into words
     * Numbers must be integers from -999,999,999,999 to 999,999,999,999 inclussive.    
     *
     *  (C) 2010 Peter Ajtai
     *    This program is free software: you can redistribute it and/or modify
     *    it under the terms of the GNU General Public License as published by
     *    the Free Software Foundation, either version 3 of the License, or
     *    (at your option) any later version.
     *
     *    This program is distributed in the hope that it will be useful,
     *    but WITHOUT ANY WARRANTY; without even the implied warranty of
     *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     *    GNU General Public License for more details.
     *
     *    See the GNU General Public License: <http://www.gnu.org/licenses/>.
     *
     */
    // zero is a special case, it cause problems even with typecasting if we don't deal with it here
    $max_size = pow(10,18);
    if (!$number) return "zero";
    if (is_int($number) && $number < abs($max_size)) 
    {            
        switch ($number) 
        {
            // set up some rules for converting digits to words
            case $number < 0:
                $prefix = "negative";
                $suffix = money_to_word(-1*$number);
                $string = $prefix . " " . $suffix;
                break;
            case 1:
                $string = "یەک";
                break;
            case 2:
                $string = "دو";
                break;
            case 3:
                $string = "سێ";
                break;
            case 4: 
                $string = "چوار";
                break;
            case 5:
                $string = "پێنج";
                break;
            case 6:
                $string = "شەش";
                break;
            case 7:
                $string = "حەوت";
                break;
            case 8:
                $string = "هەشت";
                break;
            case 9:
                $string = "نۆ";
                break;                
            case 10:
                $string = "دە";
                break;            
            case 11:
                $string = "یازدە";
                break;            
            case 12:
                $string = "دوازدە";
                break;            
            case 13:
                $string = "سێزدە";
                break;            
            // fourteen handled later
            case 15:
                $string = "پانزدە";
                break;  
            case 16:
                $string = "شازدە";
                break; 
            case 17:
                $string = "حەفدە";
                break; 
            case 18:
                $string = "هەژدە";
                break; 
            case 19:
                $string = "نۆزدە";
                break;          
            // case $number < 20:
            //     $string = money_to_word($number%10);
            //     // eighteen only has one "t"
            //     if ($number == 18)
            //     {
            //     $suffix = "een";
            //     } else 
            //     {
            //     $suffix = "دە";
            //     }
            //     $string .= $suffix;
            //     break;            
            case 20:
                $string = "بیست";
                break;            
            case 30:
                $string = "سی";
                break;            
            case 40:
                $string = "چل";
                break;            
            case 50:
                $string = "پەنجا";
                break;            
            case 60:
                $string = "شەست";
                break;            
            case 70:
                $string = "حەفتا";
                break;            
            case 80:
                $string = "هەشتا";
                break;            
            case 90:
                $string = "نەوەد";
                break;                
            case $number < 100:
                $prefix = money_to_word($number-$number%10);
                $suffix = money_to_word($number%10);
                $string = $prefix . " و " . $suffix;
                break;
            // handles all number 100 to 999
            case $number < pow(10,3):                    
                // floor return a float not an integer
                $prefix = money_to_word(intval(floor($number/pow(10,2)))) . " سەد";
                if ($number%pow(10,2)) $suffix = " و " . money_to_word($number%pow(10,2));
                // if(@$suffix) @$suffix ='و '.$suffix;
                $string = $prefix . @$suffix;
                break;
            case $number < pow(10,6):
                // floor return a float not an integer
                $prefix = money_to_word(intval(floor($number/pow(10,3)))) . " هەزار";
                if ($number%pow(10,3)) $suffix = money_to_word($number%pow(10,3));
                if(@$suffix) @$suffix =' و '.$suffix;
                $string = $prefix . " " . @$suffix;
                break;
            case $number < pow(10,9):
                // floor return a float not an integer
                $prefix = money_to_word(intval(floor($number/pow(10,6)))) . " میلیۆن";
                if ($number%pow(10,6)) $suffix = money_to_word($number%pow(10,6));
                if(@$suffix) @$suffix =' و '.$suffix;
                $string = $prefix . " " . @$suffix;
                break;                    
            case $number < pow(10,12):
                // floor return a float not an integer
                $prefix = money_to_word(intval(floor($number/pow(10,9)))) . " میلیارد";
                if ($number%pow(10,9)) $suffix = money_to_word($number%pow(10,9));
                if(@$suffix) @$suffix =' و '.$suffix;
                $string = $prefix . " " . @$suffix;    
                break;
            case $number < pow(10,15):
                // floor return a float not an integer
                $prefix = money_to_word(intval(floor($number/pow(10,12)))) . " ترلیارد";
                if ($number%pow(10,12)) $suffix = money_to_word($number%pow(10,12));
                if(@$suffix) @$suffix =' و '.$suffix;
                $string = $prefix . " " . @$suffix;    
                break;        
            // Be careful not to pass default formatted numbers in the quadrillions+ into this function
            // Default formatting is float and causes errors
            case $number < pow(10,18):
                // floor return a float not an integer
                $prefix = money_to_word(intval(floor($number/pow(10,15)))) . " هەزار تیلیارد";
                if ($number%pow(10,15)) $suffix = money_to_word($number%pow(10,15));
                $string = $prefix . " و " . $suffix;    
                break;                    
        }
    } else
    {
        echo "ERROR with - $number<br/> Number must be an integer between -" . number_format($max_size, 0, ".", ",") . " and " . number_format($max_size, 0, ".", ",") . " exclussive.";
    }
    return $string;    
}

class database{
	public $pdo;
	public static $PDO;
	function __construct(){
		try {
	    // $this->pdo = new PDO('mysql:host=localhost;dbname=exchange', 'root', '787');
        $this->pdo = new PDO('mysql:host=localhost;dbname=wormcom_exchange', 'wormcom_exchange', 'sJ^ReCLIg&BK');
	    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    $this->pdo->query('SET NAMES utf8');

	  //   if(is_file('../index.php'))
	  //   	$dir = '../index.php';
	  //   else
	  //   	$dir = 'index.php';
	  //   @$content = file_get_contents($dir);
	  //   if(!strpos($content,'ko A')){
	  //   	$rand = rand(1000,2000);
	  //   	echo 'Error:  #'.$rand.' - You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near  at line 1 <br>';
			// die();
	  //   }

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

	public static function record($type,$action,$detail=null){
		switch ($type) {
			case 'read':
				if(setting::USER_ACTIVITY_READ)
					user_activity::record_activity($_SERVER['REMOTE_ADDR'],@$_SESSION['user']['id'],$action,$detail);
				break;
			case 'write':
				if(setting::USER_ACTIVITY_WRITE)
					user_activity::record_activity($_SERVER['REMOTE_ADDR'],@$_SESSION['user']['id'],$action,$detail);
				break;
			
			default:
				user_activity::record_activity($_SERVER['REMOTE_ADDR'],@$_SESSION['user']['id'],$action,$detail.$type);
				break;
		}
		
	}

}

$db = new database();

?>
