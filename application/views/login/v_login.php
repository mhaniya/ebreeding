<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>e-Breeding - BBPTUHPT Baturraden.</title>
        
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
        <!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/assets/login/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->

	<link rel="stylesheet" type="text/css" href="/assets/login/fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/assets/login/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="/assets/login/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->

	<link rel="stylesheet" type="text/css" href="/assets/login/vendor/select2/select2.min.css">
<!--===============================================================================================-->	

	<link rel="stylesheet" type="text/css" href="/assets/login/css/util.css">
	<link rel="stylesheet" type="text/css" href="/assets/login/css/main.css">
	<link rel="shortcut icon" href="/favicon.png">
<!--===============================================================================================-->
        <body>
<div class="limiter">
	<div class="container-login100">
			
		<div class="wrap-login100">
			<form  action="<?php echo site_url('/login/proses'); ?>" method="post" class="login100-form validate-form">
			<?php
			// $err=$this->session->userdata('info_err');
			$err=$this->session->flashdata('pesan');
			
			if($err!=''){
			?>
				<div class="alert alert-danger" role="alert"><?php echo $err;?></div>
			<?php 
			} ?>
					<span class="login100-form-title p-b-26">
						e-Breeding.
					</span>
					<span class="login100-form-title p-b-48">
						<img src="/assets/images/bbptusp.png" width=100px height=100px>
					</span>

					<div class="wrap-input100 validate-input">
						<input id='username' name="username" type="text"  placeholder="username" required>
						
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
						<input name="password" value="" type="password" placeholder="password">
						
					</div>

					<button type="submit" class="btn btn-primary btn-block mt-5" name="login">Masuk</button>

					
				</form>
				<div style='text-align:center;'> <a href="/">Home</a></div>	
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1">
	<?php 
		if(isset($pesanerror))	echo "<font color='red'>".$pesanerror."</font>";
	?>
	</div>
	
<!--===============================================================================================-->
	<script src="/assets/login/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->

	<script src="/assets/login/js/main.js"></script>    
		
			
<script src="assets/js/jquery_009.js" type="text/javascript"></script>
<script>    
		$('#username').focus();
</script>
</html>
