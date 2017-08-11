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

          <table class="table">

            <thead>

                <tr>  

                    <th>Title</th>           

                    <th>Email</th>

                    <th>Website</th>

                    <th>Status</th>
                    <th>Rank</th>

                    <th class="text-center">Actions</th>

                </tr>

            </thead>

            <tbody>

                <?php

                  if (!empty($data->all_user)):

                    foreach ($data->all_user as $user):

                ?>

                <tr>

                    <td scope="row" class="invoice-title">

                        <div class="invoice-img"><img src="/assets/images/users/<?= $user->user_image ? $user->user_image : "avator.png"?>" class="img-responsive"></div>

                        <div class="invoice-meta">

                          <h2 class="invoice-id"><?=$user->first_name." ".$user->last_name;?></h2>

                          <?php if(!empty($user->country) && !empty($user->city)):?>

                          <p class="invoice-brand"><?=$user->country." , ".$user->city;?></p>
                        <?php elseif(!empty($user->country) && empty($user->city)):?>
                          <p class="invoice-brand"><?=$user->country;?></p>
                        <?php elseif(!empty($user->city) && empty($user->country)):?>
                          <p class="invoice-brand"><?=$user->city;?></p>
                        <?php endif;?>

                        </div>

                    </td>

                    <td><?=$user->email;?></td>

                    <td><?=$user->website;?></td>

                    <td><?= ($user->status == 'Inactive')? '<a class="view" href="/users/approve/'.$user->id.'">Pending</a>' : $user->status;?></td>

                    <td><?=$user->permission;?></td>

                    <td class="action-fields">

                        <a class="view" href="/users/profile/<?=$user->id?>"><i class="fa fa-eye"></i></a>

                        <a class="edit" href="/users/permission/<?=$user->id?>"><i class="fa fa-pencil"></i></a>

                        <a class="delete" href="/users/delete/<?=$user->id?>"><i class="fa fa-times"></i></a>

                    </td>

                </tr>

                <?php

                    endforeach;

                  endif;

                ?>

            </tbody>

        </table>

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