<?php
    require 'config.php';
    require $header;
    require $navbar;
    if ( !isset($session->userInfo) ) {
        Header::headerTo("../signin.php");
    } else {
        if ( $session->userInfo["role"] == "0" ) {
            Header::headerTo("../home.php");
        }
    }
?>
<title><?= SITE_NAME ?> - لوحة التحكم</title>

<div class="container" style="margin-top: 50px;">
    <div class="row">
        <div class="statistics" style="overflow: hidden">
            <div class="col m4 s12">
                <div class="indigo darken-1 white-text center-align" style="padding: 4px 2px;">
                    <p><i class="material-icons medium">person</i></p>
                    <h6 style="font-weight: bold;">عدد المستخدمين</h6>
                    <span class="countUser">[ 0 ]</span>
                </div>
            </div>
            <div class="col m4 s12">
                <div class="teal darken-2 white-text center-align" style="padding: 4px 2px;">
                    <p><i class="material-icons medium">font_download</i></p>
                    <h6 style="font-weight: bold;">عدد الكلمات</h6>
                    <span class="countWord">[ 0 ]</span>
                </div>
            </div>
            <div class="col m4 s12">
                <div class="red darken-2 white-text center-align" style="padding: 4px 2px;">
                    <p><i class="material-icons medium">warning</i></p>
                    <h6 style="font-weight: bold;">عدد الابلاغات</h6>
                    <span class="countReport">[ 0 ]</span>
                </div>
            </div>
        </div>
        <div class="table-reporting">
            <h4>الابلاغات</h4>
            <hr>
            <div class="loadingReporting center-align hide">
                <div class="preloader-wrapper active">
                  <div class="spinner-layer spinner-red-only">
                    <div class="circle-clipper left">
                      <div class="circle"></div>
                    </div><div class="gap-patch">
                      <div class="circle"></div>
                    </div><div class="circle-clipper right">
                      <div class="circle"></div>
                    </div>
                  </div>
                </div>
            </div>
            <table class="highlight centered ">
              <thead>
                <tr>
                    <th>سبب الابلاغ</th>
                    <th>مرسل الابلاغ</th>
                    <th>الكلمة الانكليزية</th>
                    <th>الكلمة العربية</th>
                    <th>التحكم</th>
                </tr>
              </thead>

              <tbody>

              </tbody>
            </table>
        </div>
    </div>
</div>

<!--loading-->
<div class="backLoading hide">
    <div class="container" style="margin-top: 150px">
        
        <div class="card-panel grey lighten-5 z-depth-1 col" style="padding: 15px;">
            <div class="row valign-wrapper" style="margin-bottom: 0;">
            <div class="col s2">
              
                <div class="preloader-wrapper small active">
                  <div class="spinner-layer spinner-red-only">
                    <div class="circle-clipper left">
                      <div class="circle"></div>
                    </div><div class="gap-patch">
                      <div class="circle"></div>
                    </div><div class="circle-clipper right">
                      <div class="circle"></div>
                    </div>
                  </div>
                </div>

            </div>
            <div class="col s10">
                <span class="black-text" style="font-size: 17px ">
                جار معالجة طلبك...
              </span>
            </div>
          </div>
        </div>
        
    </div>
</div>

<!-- خذف ابلاغ -->
<div id="deleteReport" class="modal">
  <div class="modal-content">
    <h4>تأكيد الحذف</h4>
    <p>سيتم حذف الابلاغ بالفعل, لكن هل تريد حذف الكلمة التي تم الابلاغ عنها؟</p>
  </div>
  <div class="modal-footer">
    <a href="#!" class="modal-close yes-delete-report waves-effect waves-red btn-flat">نعم</a>
    <a href="#!" class="modal-close no-delete-report waves-effect waves-green btn-flat">لا</a>
    <a href="#!" class="modal-close waves-effect waves-black btn-flat">الغاء</a>
  </div>
</div>

<!-- ارسال رسالة  -->
<!--<div id="sendMsgForUser" class="modal">
  <div class="modal-content">
    <h4>ارسال رسالة الى المستخدم</h4>
    <div class="row">
      <form class="col s12">
        <div class="row">
            <div class="input-field col s12">
              <textarea id="msg" class="materialize-textarea"></textarea>
              <label for="msg">الرسالة</label>
            </div>
            <div class="input-field col s12">
              <select>
                  
              </select>
              <label>الشخص المراد الارسال الرسالة له</label>
            </div>
            <div class="input-field col s12 left-align">
                <button class="btn waves-effect waves-light" type="submit" name="action">ارسال
                  <i class="material-icons right">send</i>
                </button>
            </div>
        </div>
      </form>
    </div>
  </div>
  <div class="modal-footer">
    <a href="#!" class="modal-close waves-effect waves-green btn-flat">الغاء</a>
  </div>
</div>-->

<?php
    require $footer;
?>
