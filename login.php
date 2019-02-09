<?php
session_start();
require_once 'class/dictionary.ku.class.php';

/*if($_SESSION['user'])
	header('location:index0.php');*/

function login($username,$password){
	if($username == 'syronz' && $password == '88888888')
		return 1;
	if($username == 'valan' && $password == '59623')
		return 2;
	if($username == 'marwan' && $password == '3327')
		return 3;
	if($username == 'muhammad' && $password == '41304')
		return 4;
	return false;
}
$msg = '';
if(isset($_POST['username'])){
	$result = login($_POST['username'],$_POST['password']);
	if($result){
		$_SESSION['user'] = $username;
		$_SESSION['id_user'] = $result;
		header('location:index.php');
		exit();
	}
	else 
		$msg = dic_return('Failed!!! Please Try again...');;
}

?>


<!DOCTYPE html>
<html lang="en">
    <head>
		<meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>Point Exchange</title>
        <meta name="author" content="Diako Amir" />
        <link rel="shortcut icon" href="icons/favicon2.ico"> 
        <link rel="stylesheet" type="text/css" href="css/login_style.css" />
		<style>	
			body {
				/*background: #7f9b4e url('images/login/bg(<?php echo rand(1,89); ?>).jpg') no-repeat center top;
				-webkit-background-size: length;
				-moz-background-size: length;
				background-size: cover;*/			
				/*background: url('images/seamlesstexture15_500.jpg');*/
				background: url('images/background.jpeg');
				background-size: cover;
				
			}
			.container > header h1,
			.container > header h2 {
				color: #fff;
				text-shadow: 0 1px 1px rgba(0,0,0,0.7);
			}

			.login_form{
				border-radius: 10px;
				background-color: rgba(255,255,255,0.3);
			}

			.msg{
				color: maroon;
				text-align: center;
				padding-top: 5px;
				font-weight: bold;
			}

			main{
				position: fixed;
				width: 100%;
				height: 100%;
				background:-webkit-radial-gradient(center top, ellipse cover, rgba(32,74,135,0.8) 20%,rgba(0,0,0,0) 100%);
			}
		</style>
    </head>
    <body>
    	<main>
        <div class="container">
        	<?php if(strpos($_SERVER["HTTP_USER_AGENT"],'Chrome') || 1):

        	?>
			<section class="main">
				<form class="login_form" action="login.php" method="post">
				    <h1>Login</h1>
				    <p>
				        <label for="login">Username</label>
				        <input type="text" name="username" placeholder="Username" required>
				    </p>
				    <p>
				        <label for="password">Password</label>
				        <input type="password" name='password' placeholder="Password" required> 
				    </p>

				    <p>
				        <input type="submit" name="submit" value="Continue">
				    </p> 
				    <p class="msg">
				   		<?php echo $msg; ?>
				    </p>
				         
				</form>​
			</section>
			<?php
				endif;
			?>
        </div>
        </main>
    </body>
</html>