<?php
    require 'config.php';
    
    $activeLink = "home"; // لتحديد اللينك المختاؤ
    
    require $header;
    require $navbar;
    if ( !isset($session->userInfo) ) {
        Header::headerTo("signin.php");
    }
?>
<title><?= SITE_NAME ?> - قاموسي</title>

<div class="container">
    <div class="card" style="margin-top: 50px">
      
    <div class="card-tabs">
      <ul class="tabs tabs-fixed-width" >
        <li class="tab"><a href="#show_words_people"><i class="material-icons">view_list</i></a></li>
        <li class="tab"><a class="active" href="#add_word"><i class="material-icons">note_add</i></a></li>
        <li class="tab"><a href="#search_word"><i class="material-icons">search</i></a></li>
        <li class="tab exam disabled"><a href="#exam"><i class="material-icons">school</i></a></li>
      </ul>
    </div>
      
    <div class="card-content grey lighten-4">
        <div id="add_word">
            <h5 class="center-align red-text lighten-4" style="margin-bottom: 50px">اضافة كلمة <span></span></h5>
            <form class="col s12">
              <div class="row">

                  <div class="input-field col s12 m6">
                      <textarea id="wordEnglish" name="wordEnglish" class="materialize-textarea" placeholder="hello" autocomplete="off"></textarea>
                      <label for="wordEnglish">اكتب هنا الكلمة المراد حفظ ترجمتها</label>
                  </div>

                  <div class="input-field col s12 m6">
                      <textarea id="wordArabic" name="wordArabic" class="materialize-textarea" placeholder="مرحبا" autocomplete="off"></textarea>
                    <label for="wordArabic">اكتب هنا ترجمة الكلمة</label>
                  </div>
                  <div class="input-field col s12 center-align">
                      <button class="btn waves-effect waves-light light-blue darken-4" type="submit" name="insert">حفظ
                        <i class="material-icons right">save</i>
                      </button>
                      <span class="helper-text red-text" data-error="wrong" data-success="right">ملاحظة:  سيتم حذف الكلمة من قِبل الادمن في حال اكتشاف خطأ فيها</span>
                  </div>
              </div>
            </form>
            
            <div class="input-field center-align loadingAfterSelect hide">
                <div class="preloader-wrapper big active">
                  <div class="spinner-layer spinner-blue-only">
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
            <div id="my_words">
                <ul class="collapsible">

                </ul>
                
            </div>
        </div>
        <div id="show_words_people">
            <h5 class="center-align red-text lighten-4" style="margin-bottom: 50px">عرض الكلمات التي شاركها الآخرون</h5>
            <span class="indigo-text center-block center-align">لن يتم عرض الكلمات الموجودة في قاموسك والكلمات التي قمت باضافتها والكلمات التي لم يشاركها الآخرون.</span>
            
            <div class="input-field center-align loadinggetWords hide">
                <div class="preloader-wrapper big active">
                  <div class="spinner-layer spinner-blue-only">
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
        
            <div id="words_people">

                <ul class="collapsible">

                </ul>

            </div>
            
        </div>
        
        <div id="search_word">
            <h5 class="center-align red-text lighten-4" style="margin-bottom: 50px">البحث عن كلمة في قاموسي</h5>
            
            <div class="input-field col s6">
                <i class="material-icons search prefix" style="cursor: pointer;">search</i>
                <input id="icon_prefix" type="text" class="validate" autocomplete="off">
                <label for="icon_prefix">ابحث بكتابة الكلمة بالانكليزية</label>
            </div>
            
            <div id="show_search">
                <h4 class="center-align"></h4>
                
                <div class="input-field center-align loadingSearch hide">
                    <div class="preloader-wrapper big active">
                      <div class="spinner-layer spinner-blue-only">
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
                
                <ul class="collapsible" style="margin-top: 40px">

                </ul>
                
            </div>
            
        </div>
        
        <div id="exam">
            <h5 class="center-align red-text lighten-4" style="margin-bottom: 50px">امتحان</h5>
            
            <div class="row">
                
                <div id="page1" class="">
                    <div class="input-field col s12">
                     <select id="chooseExam">
                        <option disabled selected>اختر طريقة الامتحان</option>
                        <option value="english">عرض الكلمات باللغة التي اخترتها والجواب عليها بالعربي</option>
                        <option value="arabic">عرض الكلمات بالعربية والجواب عليها باللغة التي اخترتها</option>
                      </select>
                      <label>طريقة الامتحان</label>
                    </div>
                    
                    <div class="input-field col s12 center-align">
                        <button class="btn waves-effect waves-light light-blue darken-4" type="submit" name="action">ابدأ الامتحان
                          <i class="material-icons right">check</i>
                        </button>
                    </div>
                    
                </div>
                
                <div id="page2" class="hide">
                    <ul>

                    </ul>
                    <div class="left-align">
                        <div class="preloader-wrapper small active hide" style="vertical-align: middle;">
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
                        <button class="btn waves-effect waves-light" type="submit" name="check">تحقق
                          <i class="material-icons right">check</i>
                        </button>
                        <button class="btn waves-effect red" type="submit" name="exit">الخروج
                          <i class="material-icons right">arrow_back</i>
                        </button>
                    </div>
                </div>
                
            </div>
            
        </div>
        
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


<!-- تعديل كلمة -->
<div id="edit" class="modal">
  <div class="modal-content">
    <h4>تعديل كلمة</h4>
        <form class="col s12">
          <div class="row">

              <div class="input-field col s12 m6">
                  <textarea id="editWordEnglish" name="editWordEnglish" class="materialize-textarea" placeholder="hello" autocomplete="off"></textarea>
                  <label for="editWordEnglish">اكتب هنا الكلمة المراد حفظ ترجمتها</label>
              </div>

              <div class="input-field col s12 m6">
                  <textarea id="editWordArabic" name="editWordArabic" class="materialize-textarea" placeholder="مرحبا" autocomplete="off"></textarea>
                <label for="editWordArabic">اكتب هنا ترجمة الكلمة</label>
              </div>
              <div class="input-field col s12 center-align">
                  <button class="btn waves-effect waves-light" type="submit" name="edit">تعديل
                    <i class="material-icons right">create</i>
                  </button>
              </div>
          </div>
        </form>
  </div>
  <div class="modal-footer">
    <a href="#!" class="modal-close waves-effect waves-green btn-flat">اغلاق</a>
  </div>
</div>
<!-- خذف كلمة -->
<div id="delete" class="modal">
  <div class="modal-content">
    <h4>تأكيد الحذف</h4>
    <p>هل تريد حذف الكلمة بالفعل؟</p>
  </div>
  <div class="modal-footer">
    <a href="#!" class="modal-close yes-delete waves-effect waves-red btn-flat">حذف</a>
    <a href="#!" class="modal-close waves-effect waves-green btn-flat">الغاء</a>
  </div>
</div>

<!-- تعديل بياناتي -->
<div id="editMyData" class="modal modal-fixed-footer">
  <div class="modal-content">
    <h4>تعديل بياناتي</h4>

        <div class="row">
            <form class="col s12">
            <div class="row">
              <div class="input-field col s12">
                <i class="material-icons prefix">person</i>
                <input id="username" name="username" type="text" data-length="20" maxlength="20" placeholder="الاسم">
                <label for="username">الاسم</label>
              </div>
              <div class="input-field col s12">
                  <i class="material-icons hidePassword prefix" style="cursor: pointer;">visibility</i>
                  <input id="password" name="password" type="password" data-length="30" maxlength="30">
                <label for="password">كلمة المرور</label>
              </div>
            </div>
            <div class="input-field col s6">
                <input id="friend" name="friend" type="text" data-length="20" maxlength="20" placeholder="اسم صديق لك">
                <label for="friend">اسم صديق لك</label>
            </div>
            <div class="input-field col s6">
                <input id="work" name="work" type="text" data-length="30" maxlength="30" placeholder="دراستك او مهنتك">
                <label for="work">دراستك او مهنتك</label>
            </div>
            <div class="input-field col s5 m3">
              <!-- Switch -->
              <div class="switch">
                <label>
                  لا
                  <input type="checkbox" id="share" name="shareWords">
                  <span class="lever"></span>
                  نعم
                </label>
              </div>
            </div>
            <div class="input-field col s7 m9 right-align">
                <span style="font-size: 13px">هل تريد مشاركة الكلمات التي قمت بحفظها مع الآخرين ليتمكنوا ايضا من حفظها وتوفير عليهم عناء البحث؟</span>
            </div>
          </form>
        </div>
    
  </div>
  <div class="modal-footer">
    <a href="#!" class="modal-close waves-effect save-data waves-green btn-flat">حفظ</a>
    <a href="#!" class="modal-close waves-effect waves-red btn-flat">إلغاء</a>
  </div>
</div>


<!-- الابلاغ -->
<div id="reporting" class="modal">
  <div class="modal-content">
    <h4>الابلاغ عن مشكلة</h4>
    <p>ماهو سبب ابلاغك لهذه الكلمة؟</p>
    <div class="input-field col s12">
      <textarea id="report" class="materialize-textarea" data-length="120"></textarea>
      <label for="report">سبب الابلاغ</label>
    </div>
  </div>
  <div class="modal-footer">
    <a href="#!" class="modal-close report waves-effect waves-red btn-flat">ابلاغ</a>
    <a href="#!" class="modal-close waves-effect waves-green btn-flat">الغاء</a>
  </div>
</div>

  <!-- انهاء الامتحان -->
  <div id="endExam" class="modal">
    <div class="modal-content">
      <h4>انتهى الامتحان</h4>
      <p>احسنت, لقد انتهى الامتحان.</p>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-close waves-effect waves-green btn-flat">حسنا</a>
    </div>
  </div>
  
  <div class="downloadApp" style="position: fixed;bottom: 10px;left: 10px;z-index: 555;">
    <a id="scale-demo" href="http://www.mediafire.com/file/03ncyoz65hca6ay/learn_Languages.apk/file" class="btn-floating teal darken-3 pulse scale-transition">
      <i class="material-icons">android</i>
    </a>
  </div>

<?php
    require $footer;
?>