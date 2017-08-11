<?php $user = new Blab\Libs\Blab_User();?>

<!DOCTYPE html>

<html lang="xyz">

  <head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>Blab Home Page</title>

    <!-- <base href="http://localhost/167473/student-management-system/"> -->

    <!-- Bootstrap -->

    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">

    <link href="/assets/css/font-awesome.min.css" rel="stylesheet">

    <link href="/assets/css/style.css" rel="stylesheet">



    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->

    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

    <!--[if lt IE 9]>

      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>

      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <![endif]-->

  </head>

  <body>

    <header>

      <nav class="navbar navbar-default navbar-fixed-top">

        <div class="container-fluid">

          <div class="navbar-header">

            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">

              <span class="sr-only">Toggle navigation</span>

              <span class="icon-bar"></span>

              <span class="icon-bar"></span>

              <span class="icon-bar"></span>

            </button>

          </div>

          <div id="navbar" class="navbar-collapse collapse" aria-expanded="false" style="height: 1px;">

            <ul class="nav navbar-nav">

              <li><a href="#" class="sidebar-collapse"><i class="fa fa-hand-o-left" aria-hidden="true"></i></a></li>

              <li><a href="/" class="logo">Logo</a></li>

              <!-- <li><input type="text" name="search" class="search" id="search" placeholder="Search"></li> -->

            </ul>

            <ul class="nav navbar-nav navbar-right">
              <?php if($user->isLoggedIn()):?>

              <?php if((new \Blab\Libs\Permission())->hasPermission('admin')):?>

                <li>

                  <a href="/users/new_users/">

                    <i class="fa fa-users" aria-hidden="true"></i>

                    <span class="notification new_users" id="new_users"><?=$user->getNewUsersList();?></span>

                  </a>

                </li>

              <?php endif;?>

              <li class="dropdown">

                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="/assets/images/users/abuahsan.jpg" class="img-responsive user-image"> <span class="caret"></span></a>

                <ul class="dropdown-menu">

                  

                  <li><a href="/users/settings/<?=$user->data()->id;?>">Settings</a></li>

                  <li><a href="/users/profile/<?=$user->data()->id;?>">Profile</a></li>

                  <li><a href="/users/logout/<?=$user->data()->id;?>">Logout</a></li>

                

                </ul>

              </li>

              <?php else:?>

              <li><a href="/users/login">Login</a></li>
              <li><a href="/users/register">Register</a></li>

              <?php endif;?>

            </ul>

          </div><!--/.nav-collapse -->

        </div>

      </nav>

    </header>