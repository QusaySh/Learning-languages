<ul id="slide-out" class="sidenav">
  <li><div class="user-view">
    <div class="background">
        <img width="300" src="../layout/images/back.jpg">
    </div>
    <a><img width="40" height="40" class="circle" src="../layout/images/logo.png"></a>
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
        <?php if ( isset($session->userInfo) ) { ?>
            <li><a href="../home.php"><i class="material-icons right">g_translate</i>قاموسي</a></li>
            <li><a href="#" class="dropdown-trigger" data-target="actionSideBar">الأدوات<i class="material-icons right">arrow_drop_down</i></a></li>
            <ul id="actionSideBar" class="dropdown-content show-on-medium-and-down">
              <li><a href="."><i class="material-icons">dashboard</i>لوحة التحكم</a></li>
                <?php if ( $session->userInfo["role"] == 2 ) { ?>
                    <li><a href="admins.php"><i class="material-icons">person</i>المستخدمين</a></li>
                    <li><a href="words.php"><i class="material-icons">font_download</i>الكلمات</a></li>
                <?php } ?>
              <li class="divider"></li>
            </ul>
            <li><div class="divider"></div></li>
            <li><a href="../?exit=true"><i class="material-icons right">arrow_back</i>خروج</a></li>
        <?php } ?>
</ul>