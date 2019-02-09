<?php
require_once 'class/database.class.php';


  // dsh(date('Y-m-d H:i:s',time()));
?>
<html>
<?php require_once 'head_tag.php'; ?>
	<style>
  		iframe{
			width: 90%;
			display:block;
			margin: 10px auto;
			/*height: 550px;*/
		}

		
  	</style>

  <body>

  	<div id="wrapper">
  		<?php  require_once 'nav.php'; ?>
  		<iframe height="580" src="http://point-exchange.url.ph/">
			<p>Your browser does not support iframes.</p>
		</iframe>
  <?php require_once 'footer.php'; ?>

  </body>
</html>
