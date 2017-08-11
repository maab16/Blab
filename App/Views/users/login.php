<?php

if((new Blab\Libs\Blab_User())->isLoggedIn())

	Blab\Libs\Redirect::to('/dashboard/');

?>

<div class="container">

	<div class="col-sm-12" style="margin-top:200px;margin-bottom:200px">

		<?php

			$input = new \Blab\Libs\Input();

			if(isset($data->login_error)){

				if(count($data->login_error)){

					foreach($data->login_error as $error){

						echo "<div class='alert-info' style='text-align:center;margin-top:10px;width:100%;'>";

						echo "<h1 style='Margine:auto'><span style='color:red'>*</span>".$error . "</h1>".'<br/>';

						echo "</div>";

					}

				}

			}

		?>

		<form id="login-form" action="" method="post" class="col-sm-5">

			<div class="login">

				<div class="col-sm-12">

					<h5>Login to your account</h5>

				</div>

				<div class="col-sm-12">

					<input type="text" name="username" class="form-control" id="username" placeholder="Username or Email">

				</div>

				<div class="col-sm-12">

					<input type="password" name="password" class="form-control" id="password" placeholder="Password">

				</div>

				<!--

				<div class="col-sm-12 recaptcha">

					<div class="g-recaptcha" data-sitekey="6Lc8Mw0TAAAAAC8VYH1bSBlW8qkcKoUXFRfSsoBP"></div>

				</div>

				-->

				<div class="col-sm-12 checkbox_div">

					<div class="col-sm-2">

						<input id="checkbox" type="checkbox" name="remember">

					</div>

					<div class="col-sm-10">

						<p id="remember_text">Remember me</p>

					</div>

					

				</div>

				

				<div class="col-sm-12">

					<input type="hidden" name="token" value="<?php echo \Blab\Libs\Token::generate();?>"/>

					<input type="submit" name="login" class="btn btn-success btn-lg submit" value="Log in">

				</div>

					

			</div>

		</form>

	</div>

</div>