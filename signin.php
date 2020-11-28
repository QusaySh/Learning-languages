<?php
    require 'config.php';
    
    $activeLink = "signin"; // لتحديد اللينك المختاؤ
    
    require $header;
    require $navbar;
    
    // في حال كان الشخص مسجل دخول
    if ( isset($session->userInfo) ) {
        Header::headerTo("home.php");
    }
    
    $signIn = new Sign();
    if ( isset($_POST["signin"]) ) {
        $signIn->setInput($_POST["username"], $_POST["password"]);
        if ( $signIn->checkSignIn() ) {
            $msg = $signIn->displayMsg();
        } else {
            if ( isset($_POST["rember"]) ) {
                setcookie("rember", $_POST["username"], strtotime("+3 day"), "/", $_SERVER["HTTP_HOST"]);
            }
            $signIn->signIn($session);
        }
    }
    
?>
<title><?= SITE_NAME ?> - تسجيل الدخول</title>

<div class="container signin">
    <div class="row" style="margin-top: 60px">
        <div class="col s12 l8 offset-l2 z-depth-2">
          <div class="card-panel white z-depth-0">
                <h4 class="center-align">تسجيل الدخول</h4>
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
                        <input required id="username" name="username" type="text" data-length="20" maxlength="20"
                               value="<?= isset($_COOKIE["rember"]) ? $_COOKIE["rember"] : "" ?>"
                        >
                        <label for="username">الاسم</label>
                      </div>
                      <div class="input-field col s12">
                          <i class="material-icons hidePassword prefix" style="cursor: pointer;">visibility</i>
                          <input required id="password" name="password" type="password" data-length="30" maxlength="30">
                        <label for="password">كلمة المرور</label>
                        <a class="helper-text modal-trigger" href="#forgetPassword" data-error="wrong" data-success="right">نسيت كلمة المرور؟</a>
                      </div>
                    </div>
                        <div class="input-field col s12" style="margin: 0;">
                        <p class="center-align">
                          <label>
                              <input type="checkbox" name="rember"/>
                            <span>تذكرني</span>
                          </label>
                        </p>
                    </div>
                    <div class="input-field col s12 left-align">
                        <button class="btn waves-effect btn-small waves-light light-blue darken-4" type="submit" name="signin">دخول
                          <i class="material-icons right">send</i>
                        </button>
                    </div>
                  </form>
                </div>
          </div>
        </div>
    </div>
</div>


  <!-- نسيت كلمة المرور -->
  <div id="forgetPassword" class="modal">
    <div class="modal-content">
        <h4 style="margin-bottom: 30px">نسيت كلمة المرور</h4>
      
        <div class="row forget">
            <div class="input-field col s12">
                <input placeholder="ادخل الاسم المراد تغيير كلمة المرور الخاصة به" id="forget_username" type="text" class="validate">
              <label for="forget_username">ادخل اسمك</label>
            </div>

            <div class="input-field col s6">
              <input placeholder="ادخل اسم الصديق الذي ادخلته عند تسجيل الحساب" id="forget_friend" type="text" class="validate">
              <label for="forget_friend">ادخل اسم صديقك</label>
            </div>

            <div class="input-field col s6">
              <input placeholder="ادخل المهنة او الدراسة الذي ادخلته عند تسجيل الحساب" id="forget_work" type="text" class="validate">
              <label for="forget_work">ادخل مهنتك او دراستك</label>
            </div>
            <div class="center-align">
                <div class="preloader-wrapper small" style="vertical-align: middle;">
                  <div class="spinner-layer spinner-green-only">
                    <div class="circle-clipper left">
                      <div class="circle"></div>
                    </div><div class="gap-patch">
                      <div class="circle"></div>
                    </div><div class="circle-clipper right">
                      <div class="circle"></div>
                    </div>
                  </div>
                </div>
                <button class="btn waves-effect waves-light send light-blue darken-4" type="submit" name="forget">التأكد من البيانات
                  <i class="material-icons right">send</i>
                </button>
            </div>
        </div>
        
        <div class="row changePassword hide">
            <div class="input-field col s12">
                <input id="new_password" type="password" class="validate" data-length="30" maxlength="30">
              <label for="new_password">ادخل كلمة المرور الجديدة</label>
            </div>
            <div class="center-align">
                <div class="preloader-wrapper small" style="vertical-align: middle;">
                  <div class="spinner-layer spinner-green-only">
                    <div class="circle-clipper left">
                      <div class="circle"></div>
                    </div><div class="gap-patch">
                      <div class="circle"></div>
                    </div><div class="circle-clipper right">
                      <div class="circle"></div>
                    </div>
                  </div>
                </div>
                <button class="btn waves-effect waves-light light-blue darken-4" type="submit" name="change">تغيير
                  <i class="material-icons right">send</i>
                </button>
            </div>
        </div>
        
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-close waves-effect waves-green btn-flat">اغلاق</a>
    </div>
  </div>

<?php
    require $footer;
?>