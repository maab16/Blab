<aside class="sidebar-menu">

  <div class="panel-group" id="accordion">

    <div class="panel panel-default">

      <div class="panel-heading">

        <h4 class="panel-title">

          <a href="/dashboard">Dashboard</a>

        </h4>

      </div>

    </div>

    <?php 

      if((new \Blab\Libs\Blab_User())->isLoggedIn()):

        if((new \Blab\Libs\Permission())->hasPermission('admin')):

    ?>

      <div class="panel panel-default">

        <div class="panel-heading">

          <h4 class="panel-title">

            <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Users</a>

          </h4>

        </div>

        <div id="collapse2" class="panel-collapse collapse">

          <ul class="sub-menu">

            <li><a class="child_panel" href="/users/">All users</a></li>

            <li><a class="child_panel" href="/users/create/">Create user</a></li>

          </ul>

        </div>

      </div>

      <?php endif;?>

    <?php endif;?>

  </div>

</aside>