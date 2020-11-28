<nav>
  <div class="nav-wrapper container">
    <a class="brand-logo right">تَعلّم اللغات</a>
    <ul id="nav-mobile" class="left">
       <li class="hide-on-med-and-down"><a href="../home.php"><i class="material-icons right">g_translate</i>قاموسي</a></li>
       <li class="hide-on-med-and-down"><a href="#" class="dropdown-trigger" data-target="actionNavBar">الأدوات<i class="material-icons right">arrow_drop_down</i></a></li>
       <li class="hide-on-med-and-down"><a href="../?exit=true"><i class="material-icons right">arrow_back</i>خروج</a></li>
       <li data-target="slide-out" class="sidenav-trigger hide-on-med-and-up show-on-medium-and-down"><a href="#!"><i class="material-icons left">menu</i></a></li>
    </ul>
    <ul id="actionNavBar" class="dropdown-content hide-on-med-and-down">
        <li><a href="."><i class="material-icons">dashboard</i>لوحة التحكم</a></li>
        <?php if ( $session->userInfo["role"] == 2 ) { ?>
        <li><a href="admins.php"><i class="material-icons">person</i>المستخدمين</a></li>
        <li><a href="words.php"><i class="material-icons">font_download</i>الكلمات</a></li>
        <?php } ?>
    </ul>
  </div>
</nav>
<?php require $sidebar; ?>