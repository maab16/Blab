    <!-- Start Main -->
    <main class="main">
      <!-- Start Sidebar Menu -->
      <?php require_once VIEWS_PATH.DS.'aside.php';?>
      <!--End Sidebar Menu-->
      <!-- Start Content -->
      <section class="content-container">
        <div class="content profile-content">
          <?php

          $input = new \Blab\Libs\Input();

          if(isset($data->signup_error)){
            if(count($data->signup_error)){

              foreach($data->signup_error as $error){

                echo "<div class='alert-info' style='text-align:center;margin-top:10px;width:100%;'>";
                                
                echo "<h1 style='Margine:auto'><span style='color:red'>*</span>".$error . "</h1>".'<br/>';
                echo "</div>";
              }
            }
          }
        ?>
          <form id="registration" action="" method="post">
            <div class="col-sm-8 register"> 
              <div class="col-sm-12">
                <h5>New user Registation</h5>
              </div>
              <div class="col-sm-12">
                <input type="text" name="username" class="form-control" id="username" placeholder="Username" value="<?= $input::get('username');?>">
              </div>
              <div class="col-sm-12">
                <input type="text" name="email" class="form-control" id="email" placeholder="Email" value="<?= $input::get('email');?>">
              </div>
              <div class="col-sm-12">
                <input type="password" name="password" class="form-control" id="password" placeholder="Password" value="<?= $input::get('password');?>">
              </div>
              <div class="col-sm-12">
                <input type="password" name="re_password" class="form-control" id="re_password" placeholder="Re-enter Password" value="<?= $input::get('re_password');?>">
              </div>
              <div class="col-sm-12">
                <input type="submit" name="signup" class="btn btn-success btn-lg submit" value="Register">
              </div>
            </div>
          </form>
        </div>
      </section><!--End Content-->
    </main>