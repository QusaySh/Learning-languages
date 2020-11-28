<nav>
  <div class="nav-wrapper container">
    <a class="brand-logo right">تَعلّم اللغات</a>
    <ul id="nav-mobile" class="left">
       <?php if ( !isset($session->userInfo) ) { ?>
       <li class="hide-on-med-and-down <?= $activeLink == "signup" ? "active" : "" ?>"><a href="signup.php"><i class="material-icons right">person_add</i>تسجيل</a></li>
       <li class="hide-on-med-and-down <?= $activeLink == "signin" ? "active" : "" ?>"><a href="signin.php"><i class="material-icons right">arrow_forward</i>دخول</a></li>
       <?php } else { ?>
       <li class="hide-on-med-and-down"><a class="modal-trigger" href="#editMyData"><i class="material-icons right">person</i><?= $session->userInfo["username"] ?></a></li>
       <?php if ( $session->userInfo["role"] > 0 ) { ?>
       <li class="hide-on-med-and-down"><a class="modal-trigger" href="dashboard/index.php"><i class="material-icons right">dashboard</i>لوحة التحكم</a></li>
       <?php } ?>
       <li class="hide-on-med-and-down <?= $activeLink == "home" ? "active" : "" ?>"><a href="home.php"><i class="material-icons right">g_translate</i>قاموسي</a></li>
       <li class="hide-on-med-and-down"><a href="?exit=true"><i class="material-icons right">arrow_back</i>خروج</a></li>
       <?php } ?>
       <li data-target="slide-out" class="sidenav-trigger hide-on-med-and-up show-on-medium-and-down"><a href="#!"><i class="material-icons left">menu</i></a></li>
    </ul>
  </div>
</nav>
<?php require $sidebar; ?>
<script src="layout/js/browser.js"></script>