<?php
    require 'config.php';
    require $header;
    require $navbar;
    if ( !isset($session->userInfo) ) {
        Header::headerTo("../signin.php");
    }
?>
<title><?= SITE_NAME ?> - الكلمات</title>
<div class="container">
    <div class="row">
        <h3 class="center-align" style="margin-bottom: 40px">الكلمات</h3>
        <div class="table-words">
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
            
            <div class="row">
                <div class="col s12">
                    <div class="input-field col s12 m6">
                      <select id="lang">
                        <option value="" disabled selected>جلب الكلمات حسب اللغة</option>
                        <option value="English">الانكليزية</option>
                        <option value="French">الفرنسية</option>
                        <option value="German">الالمانية</option>
                        <option value="Turkish">التركية</option>
                        <option value="Finland">الفيلندية</option>
                      </select>
                      <label>احتر اللغة التي ستجلب كلماتها</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <select id="nameUsers">
                            
                        </select>
                      <label>اختر اسم الشخص الذي ستجلب كلماته</label>
                    </div>
                </div>
            </div>
            
            <table class="highlight centered responsive-table">
              <thead>
                <tr>
                    <th>اسم المستخدم</th>
                    <th>اللغة</th>
                    <th>الكلمة الانكليزية</th>
                    <th>الترجمة</th>
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
<div id="deleteWord" class="modal">
  <div class="modal-content">
    <h4>تأكيد الحذف</h4>
    <p>هل تريد حذف الكلمة بالفعل؟</p>
  </div>
  <div class="modal-footer">
    <a href="#!" class="modal-close yes-delete-word waves-effect waves-red btn-flat">حذف</a>
    <a href="#!" class="modal-close waves-effect waves-green btn-flat">الغاء</a>
  </div>
</div>

<?php
    require $footer;
?>