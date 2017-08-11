    <!-- Start Main -->
    <main class="main">
      <!-- Start Sidebar Menu -->
      <?php require_once VIEWS_PATH.DS.'aside.php';?>
      <!--End Sidebar Menu-->
      <!-- Start Content -->
      <section class="content-container">
        <div class="content profile-content">
          <?php 
              if(!empty($data->single_user)):
               $user = $data->single_user;
          ?>
          <div class="row">
              <div class="col-sm-5">
                <div class="profile-image-container"><img src="/assets/images/users/<?= $user->user_image ? $user->user_image : "avator.png"?>" class="img-responsive"></div>
              </div>
              <div class="col-sm-7">
                <?php if($user->first_name || $user->last_name):?>
                <h2 class="title"><?= $user->first_name ?: "" ?> <?= $user->last_name ?: "" ?></h2>
                <?php endif;?>
                <p class="overview">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Placeat nam mollitia officiis deleniti quae quos. Nulla voluptate, quibusdam dolor vero sed voluptatum, incidunt eum dicta, iste beatae animi inventore repudiandae.</p>
              </div>
            </div>
            <div class="row">
              <?php if($user->username):?>
              <div class="form-group">
                <div class="field_label"><span>username</span> : </div>
                <div class="field_value"><span><?= $user->username ?: "" ?></span></div>
              </div>
              <?php endif;?>
              <?php if($user->email):?>
              <div class="form-group">
                <div class="field_label"><span>email</span> : </div>
                <div class="field_value"><span><?= $user->email ?: "" ?></span></div>
              </div>
              <?php endif;?>
              <?php if($user->company):?>
              <div class="form-group">
                <div class="field_label"><span>Company</span> : </div>
                <div class="field_value"><span><?= $user->company ?: "" ?></span></div>
              </div>
              <?php endif;?>
              <?php if($user->mobile):?>
              <div class="form-group">
                <div class="field_label"><span>mobile</span> : </div>
                <div class="field_value"><span><?= $user->mobile ?: "" ?></span></div>
              </div>
              <?php endif;?>
              <?php if($user->phone):?>
              <div class="form-group">
                <div class="field_label"><span>phone</span> : </div>
                <div class="field_value"><span><?= $user->phone ?: "" ?></span></div>
              </div>
              <?php endif;?>
              <?php if($user->website):?>
              <div class="form-group">
                <div class="field_label"><span>website</span> : </div>
                <div class="field_value"><span><?= $user->website ?: "" ?></span></div>
              </div>
              <?php endif;?>
              <?php if($user->country):?>
              <div class="form-group">
                <div class="field_label"><span>Country</span> : </div>
                <div class="field_value"><span><?= $user->country ?: "" ?></span></div>
              </div>
              <?php endif;?>
              <?php if($user->city):?>
              <div class="form-group">
                <div class="field_label"><span>City</span> : </div>
                <div class="field_value"><span><?= $user->city ?: "" ?></span></div>
              </div>
              <?php endif;?>
              <?php if($user->address):?>
              <div class="form-group">
                <div class="field_label"><span>Address</span> : </div>
                <div class="field_value"><span><?= $user->address ?: "" ?></span></div>
              </div>
            <?php endif;?>
            </div>
          <?php endif;?>
        </div>
      </section><!--End Content-->
    </main>