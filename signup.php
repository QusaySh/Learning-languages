<?php
    require 'config.php';
    
    $activeLink = "signup";
    
    require $header;
    require $navbar;
    
    // في حال كان الشخص مسجل دخول
    if ( isset($session->userInfo) ) {
        Header::headerTo("home.php");
    }
    
    // في حال الضغط على زر تسجيل حساب
    if ( isset($_POST['signup']) ) {
        $signUp = new Sign;
        $lang = !isset($_POST["language"]) ? "" : $_POST["language"];
        $share = !isset($_POST["shareWords"]) ? "off" : $_POST["shareWords"];
        $signUp->setInput($_POST["username"], $_POST["password"], $lang, $_POST["friend"], $_POST["work"], $share);
        if ( $signUp->checkSignUp() ) {
            $msg = $signUp->displayMsg();
        } else {
            $signUp->signUp($session);
        }
    }
    
?>
<title><?= SITE_NAME ?> - تسجيل حساب</title>
<div class="container signup">
    <div class="row" style="margin-top: 60px">
        <div class="col s12 l8 offset-l2 z-depth-2">
          <div class="card-panel white z-depth-0">
                <h4 class="center-align">تسجيل حساب</h4>
                <?php
                    if ( isset($msg) ) {
                        foreach ( $msg as $m ) {
                            echo $m;
                        }
                    }
                ?>
                <div class="row">
                    <form class="col s12" action="<?= $_SERVER["PHP_SELF"]; ?>" method="POST">
                    <div class="row">
                      <div class="input-field col s12">
                        <i class="material-icons prefix">person</i>
                        <input id="username" name="username" type="text" data-length="20" maxlength="20"
                               value="<?= isset($_POST["username"]) ? $_POST["username"] : "" ?>"
                        >
                        <label for="username">الاسم</label>
                      </div>
                      <div class="input-field col s12">
                          <i class="material-icons hidePassword prefix" style="cursor: pointer;">visibility</i>
                          <input id="password" name="password" type="password" data-length="30" maxlength="30"
                                 value="<?= isset($_POST["password"]) ? $_POST["password"] : "" ?>"
                          >
                        <label for="password">كلمة المرور</label>
                      </div>
                    </div>
                    <div class="input-field col s12">
                        <select name="language">
                        <option value="" disabled selected>اختر اللغة التي ستتعلمها</option>
                        <option <?= isset($_POST["language"]) && $signUp->selected($_POST["language"], "English") ? "selected" : "" ?>
                            value="English">الانكليزية</option>
                        <option <?= isset($_POST["language"]) && $signUp->selected($_POST["language"], "French") ? "selected" : "" ?>
                            value="French">الفرنسية</option>
                        <option <?= isset($_POST["language"]) && $signUp->selected($_POST["language"], "German") ? "selected" : "" ?>
                            value="German">الالمانية</option>
                        <option <?= isset($_POST["language"]) && $signUp->selected($_POST["language"], "Turkish") ? "selected" : "" ?>
                            value="Turkish">التركية</option>
                        <option <?= isset($_POST["language"]) && $signUp->selected($_POST["language"], "Finland") ? "selected" : "" ?>
                            value="Finland">الفيلندية</option>
                      </select>
                      <label>اختيار اللغة</label>
                    </div>
                    <div class="input-field col s6">
                        <input id="friend" name="friend" type="text" data-length="20" maxlength="20"
                               value="<?= isset($_POST["friend"]) ? $_POST["friend"] : "" ?>"
                        >
                        <label for="friend">اسم صديق لك</label>

                    </div>
                    <div class="input-field col s6">
                        <input id="work" name="work" type="text" data-length="30" maxlength="30"
                               value="<?= isset($_POST["work"]) ? $_POST["work"] : "" ?>"
                        >
                        <label for="work">دراستك او مهنتك</label>
                    </div>
                    <div class="input-field col s5 m3">
                      <!-- Switch -->
                      <div class="switch">
                        <label>
                          لا
                          <input type="checkbox" checked name="shareWords" <?= isset($_POST["shareWords"]) && $signUp->selected($_POST["shareWords"], "on") ? "checked" : "" ?>>
                          <span class="lever"></span>
                          نعم
                        </label>
                      </div>
                    </div>
                    <div class="input-field col s7 m9 right-align">
                        <span style="font-size: 13px">هل تريد مشاركة الكلمات التي قمت بحفظها مع الآخرين ليتمكنوا ايضا من حفظها وتوفير عليهم عناء البحث؟</span>
                    </div>
                    <div class="input-field col s12 left-align">
                        <button class="btn waves-effect btn-small light-blue darken-4 waves-light" type="submit" name="signup">تسجيل
                          <i class="material-icons right">send</i>
                        </button>
                    </div>
                  </form>
                </div>
          </div>
        </div>
    </div>
</div>
<?php
    require $footer;
?>