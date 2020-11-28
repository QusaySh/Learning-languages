<?php
    require 'config.php';
    
    require $header;
    require $navbar;
?>
<title><?= SITE_NAME ?> - الصفحة الرئيسية</title>
<div class="row" style="margin-top: 60px">
    <div class="col s12 l6 offset-l3">
      <div class="card-panel white z-depth-0 center-align">
          <h4 class="red-text darken-1">تَعلّم اللغات</h4>
          <span class="black-text" style="font-size: 18px;line-height: 2">
            هو موقع يتيح لك تعلم اللغات عن طريق حفظ كلمات هذه اللغات, باضافة الكلمات التي تحفظها او استيرادها من الاشخاص الذين قامو بمشاركة الكلمات الخاصة بهم وامتحانك بهذه الكلمات في آي وقت تشاء.
        </span>
      </div>
    </div>
</div>
<?php
    require $footer;
?>