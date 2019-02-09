<?php
	require_once 'class/database.class.php';

	date_default_timezone_set("Asia/Baghdad");
	$file_name = $_GET['file_name'];
	// dsh($file_name);
	$target = '/var/www/backups/'.$file_name;
	// $target = '/var/www/html/exchange/backups/'.$file_name;

	#dsh note: 
	//system("c:/xampp/mysql/bin/mysql -u root --password= exchange < $target");
	echo system("mysql -u root --password='point13661364' exchange < $target");
	// system("mysql -u root --password='!@#$%%$#@!mysql' exchange < $target");


	// header('Content-type: text/appdb');
	// header('Content-Disposition: attachment; filename="' . $file_name);
	// readfile($target);
	// @unlink($target);
	// exit(0);

?>
<style type="text/css">
#page-wrapper{
	width: 900px;
	margin: 50px auto;
	margin-bottom: 100px;
	background-color: #FFF;
	padding: 50px;
}
			meter,
			progress {
			  width: 100%;
			}
			.styled meter {
			  /* Reset the default appearance */
			  -webkit-appearance: none;
			  appearance: none;
			  width: 100%;
			  height: 30px;
			  /* For Firefox */
			  background: #EEE;
			  box-shadow: 0 2px 3px rgba(0,0,0,0.2) inset;
			  border-radius: 3px;
			}
			/* WebKit */
			.styled meter::-webkit-meter-bar {
			  background: #EEE;
			  box-shadow: 0 2px 3px rgba(0,0,0,0.2) inset;
			  border-radius: 3px;
			}

			.styled meter::-webkit-meter-optimum-value {
			  background: #86CC00;
			}
			.styled meter::-webkit-meter-suboptimum-value {
			  background: #86CC00;
			}
			.styled meter::-webkit-meter-even-less-good-value  {
			  background: #86CC00;
			}

			#money_transfer_btn {
				box-shadow:inset 0px 1px 0px 0px #ffffff;
				filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ededed', endColorstr='#dfdfdf');
				background-color:#ededed;
				border-top-left-radius:6px;
				border-top-right-radius:6px;
				border-bottom-right-radius:6px;
				border-bottom-left-radius:6px;
				text-indent:0;
				border:1px solid #dcdcdc;
				color:#777777;
				font-family:arial;
				font-size:15px;
				font-weight:bold;
				font-style:normal;
				height:30px;
				cursor: pointer;
				width:200px;
				text-decoration:none;
				text-align:center;
				text-shadow:1px 1px 0px #ffffff;

				display:none;
			}
			#money_transfer_btn:hover {
				background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #dfdfdf), color-stop(1, #ededed) );
				background-color:#dfdfdf;
			}
			#money_transfer_btn:active {
				position:relative;
				top:1px;
			}
			#i_count{
				text-align: center;
				margin-top: -25px;
				font-family: Calibri;
				margin-top: -43px;
				font-weight: bold;
				font-size: 19px;
			}
		</style>
<html>
<?php require_once 'head_tag.php'; ?>
  <body>
  	<div id="wrapper">
  		<?php require_once 'nav.php'; ?>
		<div id="main">
			<div id="page-wrapper">
			<p class="styled">
				<meter min="0" max="100" low="25" high="75" optimum="100" value="80" id="proress_bar"></meter>
				<p id="i_count">36 %</p>
			</p>
			<div style="margin:10px auto; text-align:center; height:150px;margin-bottom: 150px;">
				<a href="index.php"><button id="money_transfer_btn"><?php echo dic_return('Restore Complete'); ?></button></a>
			</div>
			</div>
			<script type="text/javascript">
				var p_bar = document.getElementById('proress_bar');
				p_bar.value = 2;
				console.log(p_bar.value);

				var myVar=setInterval(function(){myTimer()},30);
				var n = 1;
				function myTimer(){
					document.getElementById("proress_bar").value = n;
					if(n < 101)
						document.getElementById("i_count").innerHTML = n + ' %';
					
					n++;
					if(n==100){
						document.getElementById("money_transfer_btn").style.display = 'inline-block';
					}
					// console.log(n);
				}
			</script>
		</div>
		<?php require_once 'footer.php'; ?>
	</div>

 
  </body>
</html>


