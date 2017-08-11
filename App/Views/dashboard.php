<?php if((new Blab\Libs\Blab_User())->isLoggedIn()):?>

<?php require_once('header.php');?>
	<main>

        <?php if(Blab\Libs\Session::hasFlash()){?>

          <div class="alert alert-info" role="alert">

            <?php Blab\Libs\Session::flashMessage();?>

          </div>

        <?php }?>

        <?=$data['content'];?> <!--This line output action Data-->
    </main>

<?php require_once('footer.php');?>

<?php endif;?>