<?php require_once('header.php');?>

      <div class="container-fluid">

      	<?php if(Blab\Libs\Session::hasFlash()){?>

	      	<div class="alert alert-info" role="alert">

	      		<?php Blab\Libs\Session::flashMessage();?>

	      	</div>

      	<?php }?>

        <?=$data['content']?> <!--This line output action Data-->

      </div>

<?php require_once('footer.php');?>