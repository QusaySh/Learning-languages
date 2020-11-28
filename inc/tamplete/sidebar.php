<ul id="slide-out" class="sidenav">
  <li><div class="user-view">
    <div class="background">
        <img width="300" src="layout/images/back.jpg">
    </div>
    <a><img width="40" height="40" class="circle" src="layout/images/logo.png"></a>
    <a>
        <span class="white-text name">
            <h5>
                <?php
                    if (isset($session->userInfo["username"])) {
                        echo '<a class="modal-trigger white-text" href="#editMyData">' .$session->userInfo["username"].'</a>';
                    } else {
                        echo SITE_NAME;
                    }
                ?>
            </h5>
        </span>
    </a>
    <a>
        <span class="white-text email">
            <?php
                if (isset($session->userInfo["language"])) {
                    echo $session->userInfo["language"];
                } else {
                    echo "تعلم اللغات باسهل طريقة";
                }
            ?>
        </span>
    </a>
  </div></li>
        <?php if ( !isset($session->userInfo) ) { ?>
            <li class="<?= $activeLink == "signup" ? "active" : "" ?>"><a href="signup.php"><i class="material-icons right">person_add</i>تسجيل</a></li>
            <li class="<?= $activeLink == "signin" ? "active" : "" ?>"><a href="signin.php"><i class="material-icons right">arrow_forward</i>دخول</a></li>
        <?php } else { ?>
            <?php if ( $session->userInfo["role"] > 1 ) { ?>
            <li><a class="modal-trigger" href="dashboard/index.php"><i class="material-icons right">dashboard</i>لوحة التحكم</a></li>
            <?php } ?>
            <li class="<?= $activeLink == "home" ? "active" : "" ?>"><a href="home.php"><i class="material-icons right">g_translate</i>قاموسي</a></li>
            <li><div class="divider"></div></li>
            <li><a href="?exit=true"><i class="material-icons right">arrow_back</i>خروج</a></li>
        <?php } ?>
</ul>