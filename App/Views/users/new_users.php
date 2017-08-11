<!-- Start Main -->
<main class="main">
  <!-- Start Sidebar Menu -->
  <?php require_once VIEWS_PATH.DS.'aside.php';?>
  <!--End Sidebar Menu-->
  <!-- Start Content -->
  <section class="content-container">
    <h2 class="title dashboard-title">Users</h2>
    <div class="content">
      <div class="row">
        <div class="invoice">
          <?php if (!empty($data->new_users)):?>
          <table class="table">
            <thead>
                <tr>  
                    <th>Title</th>           
                    <th>Email</th>
                    <th>Website</th>
                    <th>Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data->new_users as $user):?>
                <tr>
                    <td scope="row" class="invoice-title">
                        <div class="invoice-img"><img src="/assets/images/users/<?= $user->user_image ? $user->user_image : "avator.png"?>" class="img-responsive"></div>
                        <div class="invoice-meta">
                          <h2 class="invoice-id"><?=$user->first_name." ".$user->last_name;?></h2>
                          <p class="invoice-brand"><?=$user->country." , ".$user->city;?></p>
                        </div>
                    </td>
                    <td><?=$user->email;?></td>
                    <td><?=$user->website;?></td>
                    <td><?= ($user->status == 'Inactive')? '<a class="view" href="/users/approve/'.$user->id.'">Pending</a>' : $user->status;?></td>
                    <td class="action-fields">
                        <a class="view" href="/users/profile/<?=$user->id?>"><i class="fa fa-eye"></i></a>
                        <a class="edit" href="/users/permission/<?=$user->id?>"><i class="fa fa-pencil"></i></a>
                        <a class="delete" href="/users/delete/<?=$user->id?>"><i class="fa fa-times"></i></a>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
        <?php else:?>
          <h3>There is no new user.</h3>
        <?php endif;?>
      </div>
        
        <div id='pagination_controls'>
        <?php

          if (!empty($data->pagination_controll)) {
          
            echo $data->pagination_controll;
          }
        ?>
      </div>

      </div>
    </div>
  </section><!--End Content-->
</main>