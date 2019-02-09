<?php
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

backup_tables('localhost','root','787','exchange');

/* backup the db OR just a table */
function backup_tables($host,$user,$pass,$name,$tables = '*')
{
	
	// $link = mysql_connect($host,$user,$pass);
	// mysql_select_db($name,$link);

	$PDO = new PDO("mysql:host=$host;dbname=$name", $user, $pass);
	
	//get all of the tables
	if($tables == '*')
	{
		$tables = array();
		$result = $PDO->query('SHOW TABLES');
		$tables = $result->fetchAll(PDO::FETCH_NUM)[0];

		dsh($tables);
	}
	else
	{
		$tables = is_array($tables) ? $tables : explode(',',$tables);
	}
	
	//cycle through
	foreach($tables as $table)
	{
		dsh($table);
		$result = $PDO->query('SELECT * FROM '.$table);
		$num_fields = $result->columnCount();;
		
		$return.= 'DROP TABLE '.$table.';';
		$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
		$return.= "\n\n".$row2[1].";\n\n";
		
		for ($i = 0; $i < $num_fields; $i++) 
		{
			while($row = mysql_fetch_row($result))
			{
				$return.= 'INSERT INTO '.$table.' VALUES(';
				for($j=0; $j < $num_fields; $j++) 
				{
					$row[$j] = addslashes($row[$j]);
					$row[$j] = ereg_replace("\n","\\n",$row[$j]);
					if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
					if ($j < ($num_fields-1)) { $return.= ','; }
				}
				$return.= ");\n";
			}
		}
		$return.="\n\n\n";
	}
	
	//save file
	$handle = fopen('db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql','w+');
	fwrite($handle,$return);
	fclose($handle);
}

?>