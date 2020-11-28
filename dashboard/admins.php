<?php
    require 'config.php';
    require $header;
    require $navbar;
    if ( !isset($session->userInfo) ) {
        Header::headerTo("../signin.php");
    } else {
        if ( $session->userInfo["role"] != "2" ) {
            Header::headerTo("../home.php");
        }
    }
?>
<div class="container">
    <div class="row">
        <h3 class="center-align" style="margin-bottom: 40px">بيانات المستخدمين</h3>
        <div class="table-admin">
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
            <table class="highlight centered responsive-table">
              <thead>
                <tr>
                    <th>اسم المستخدم</th>
                    <th>الصلاحية</th>
                    <th>اللغة التي اختارها</th>
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

<!-- خذف مستخدم -->
<div id="deleteUser" class="modal">
  <div class="modal-content">
    <h4>تأكيد الحذف</h4>
    <p>هل تريد حذف المستخدم بالفعل؟</p>
  </div>
  <div class="modal-footer">
    <a href="#!" class="modal-close yes-delete-user waves-effect waves-red btn-flat">حذف</a>
    <a href="#!" class="modal-close waves-effect waves-green btn-flat">الغاء</a>
  </div>
</div>

<?php
    require $footer;
?>