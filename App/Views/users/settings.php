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
          <form action="/users/settings/" method="post" class="profile-form" enctype="multipart/form-data">
            <div class="row">
              <div class="col-sm-3">
                <div class="profile-image-container"><img src="/assets/images/users/<?= $user->user_image ? $user->user_image : "avator.png"?>" class="img-responsive"></div>
                <input type="file" name="image" id="profile-image" />
              </div>
              <div class="col-sm-9">
                <div class="user_name input_field">
                  <input type="text" name="fname" id="fname" class="fname" value="<?= $user->first_name ?: "" ?>" placeholder="Enter First Name">
                  <input type="text" name="lname" id="lname" class="lname" value="<?= $user->last_name ?: "" ?>"  placeholder="Enter Last Name">
                </div>
                <div class="user_overview input_field">
                  <textarea name="overview" class="oveview"  placeholder="Enter overview">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Placeat nam mollitia officiis deleniti quae quos. Nulla voluptate, quibusdam dolor vero sed voluptatum, incidunt eum dicta, iste beatae animi inventore repudiandae.</textarea>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group">
                <div class="field_label"><label>username</label> : </div>
                <div class="input_field"><input type="text" name="username" class="username" value="<?= $user->username ?: "" ?>" readonly=""></div>
              </div>
              <div class="form-group">
                <div class="field_label"><label>email</label> : </div>
                <div class="input_field"><input type="text" name="email" class="email" value="<?= $user->email ?: "" ?>" placeholder="Enter Email"></div>
              </div>
              <!-- <div class="form-group">
                <div class="field_label"><label>Password</label> : </div>
                <div class="input_field"><input type="password" name="password" class="password" value="" placeholder="Enter Password"></div>
              </div>
              <div class="form-group">
                <div class="field_label"><label>Re Password</label> : </div>
                <div class="input_field"><input type="password" name="re_password" class="password" value="" placeholder="Re Enter Password"></div>
              </div> -->
              <div class="form-group">
                <div class="field_label"><label>Company</label> : </div>
                <div class="input_field"><input type="text" name="company" class="company" value="<?= $user->company ?: "" ?>"  placeholder="Enter Company Name"></div>
              </div>
              <div class="form-group">
                <div class="field_label"><label>mobile</label> : </div>
                <div class="input_field"><input type="text" name="mobile" class="mobile" value="<?= $user->mobile ?: "" ?>"  placeholder="Enter Mobile Number"></div>
              </div>
              <div class="form-group">
                <div class="field_label"><label>phone</label> : </div>
                <div class="input_field"><input type="text" name="phone" class="phone" value="<?= $user->phone ?: "" ?>"  placeholder="Enter Phone Number"></div>
              </div>
              <div class="form-group">
                <div class="field_label"><label>website</label> : </div>
                <div class="input_field"><input type="text" name="website" class="website" value="<?= $user->website ?: "" ?>"  placeholder="Enter Website"></div>
              </div>
              <div class="form-group">
                <div class="field_label"><label>Country</label> : </div>
                <div class="input_field"><input type="text" name="country_code" class="countr" value="<?= $user->country ?: "" ?>"  placeholder="Enter Country"></div>
              </div>
              <div class="form-group">
                <div class="field_label"><label>City</label> : </div>
                <div class="input_field"><input type="text" name="city" class="city" value="<?= $user->city ?: "" ?>"  placeholder="Enter City"></div>
              </div>
              <div class="form-group">
                <div class="field_label"><label>Address</label> : </div>
                <div class="input_field"><textarea name="address" class="address"  placeholder="Enter Address"><?= $user->address ?: "" ?></textarea></div>
              </div>
            </div>
            <div class="update_profile_container text-center">
              <input type="hidden" name="id" value="<?= $user->id ?: "" ?>">
              <input type="submit" name="update_profile" value="Update" id="update_profile" class="btn btn-lg btn-success">
            </div>
          </form>
          <?php endif;?>
        </div>
      </section><!--End Content-->
    </main>