<?php
// phpinfo();
date_default_timezone_set("Asia/Baghdad");
$file_name = date('Y-m-d_H.i.s',time()).'.sql';
$target = '/var/www/backups/'.$file_name;
#in windows xampp
// system("c:/xampp/mysql/bin/mysqldump -u root --password= exchange > $target"); 

system("mysqldump -u root --password='787' exchange > $target");
header('Content-type: text/appdb');
header('Content-Disposition: attachment; filename="' . $file_name);
readfile($target);
// @unlink($target);
exit(0);

?>
