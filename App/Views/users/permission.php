    <!-- Start Main -->
    <main class="main">
      <!-- Start Sidebar Menu -->
      <?php require_once VIEWS_PATH.DS.'aside.php';?>
      <!--End Sidebar Menu-->
      <!-- Start Content -->
      <section class="content-container">
        <div class="content profile-content">
          <form action="/users/permission/" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <div class="field_label"><label>username</label> : </div>
              <div class="input_field"><input type="text" name="username" class="username" value="<?= $data->user_permission->username ?: "" ?>" readonly=""></div>
            </div>

            <div class="form-group">
              <div class="field_label"><label>Permission</label> : </div>
              <div class="input_field">
                <select name="permission" class="permission form-control">
                  <?php
                    if (!empty($data->permissions)):
                      foreach($data->permissions as $permission):
                  ?>
                    <?php if($permission->id == $data->user_permission->grp):?>
                        <option value="<?=$permission->id?>" class="form-control" selected><?=$permission->group_name;?></option>
                    <?php else:?>
                      <option value="<?=$permission->id?>"  class="form-control"><?=$permission->group_name;?></option>
                    <?php endif;?>
                  <?php
                    endforeach;
                    endif;
                  ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="field_label"><label>Status</label> : </div>
              <div class="input_field">
                <select name="status" class="permission form-control">
                  <?php
                    if (!empty($data->status)):
                      foreach($data->status as $status):
                  ?>
                    <?php if($status->status_id == $data->user_status->active):?>
                        <option value="<?=$status->status_id?>" class="form-control" selected><?=$status->title;?></option>
                    <?php else:?>
                      <option value="<?=$status->status_id?>"  class="form-control"><?=$status->title;?></option>
                    <?php endif;?>
                  <?php
                    endforeach;
                    endif;
                  ?>
                </select>
              </div>
            </div>
            <div class="permission_button text-right">
              <input type="hidden" name="id" value="<?=$data->user_permission->id;?>">
              <input type="submit" name="user_permission" class="btn btn-lg btn-success" value="Set Permission">
            </div>
          </form>
        </div>
      </section><!--End Content-->
    </main>