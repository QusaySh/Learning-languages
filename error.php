<?php
    require 'config.php';

    require $header;
?>
<div class="container" style="margin-top: 50px;margin-bottom: 50px;">
    <div class="row">
        <div class="col s12 m8 offset-m2">
            <div class="whit z-depth-1" style="padding: 10px">
                <div class="center-align">
                    <h4 class="red-text" style="margin-bottom: 30px">حصل خطأ</h4>
                    <img src="layout/images/error.png" />
                </div>
               
                <div class="card-panel center-align" style="background: transparent;box-shadow: none;">
                    <?php
                        if ( isset($_GET["browser"]) ) {
                            if ( $_GET["browser"] == "Opera" || $_GET["browser"] == "MSIE" ) {
                                if ( $_GET["browser"] == "Opera" ) {
                                    echo "<p class='center-align'>لايمكن استخدام الموقع بواسطة متصفح Opera</p>";
                                } else {
                                    echo "<p class='center-align'>لايمكن استخدام الموقع بواسطة متصفح انترنت اكسبلورر</p>";
                                }
                            } else {
                                echo "<p>عذرا, المتصفح الذي لديك قديم, قم بتحديثه من خلال الروابط التالية</p>";
                                if ( $_GET["browser"] == "Chrome" ) {
                                    echo "<div class='col s6'>";
                                        echo "<a href='https://apkpure.com/ar/google-chrome-fast-secure/com.android.chrome'>Chrome Mobile</a>";
                                    echo "</div>";
                                    echo "<div class='col s6'>";
                                        echo "<a href='https://www.mutaz.net/free-programs/download/?41'>Chrome Computer 64bit</a><br>";
                                        echo "<a href='https://www.mutaz.net/free-programs/download/?42'>Chrome Computer 32bit</a>";
                                    echo "</div>";
                                } else if ( $_GET["browser"] == "Firefox" ) {
                                    echo "<div class='col s6'>";
                                        echo "<a href='https://apkpure.com/ar/firefox-browser-fast-private/org.mozilla.firefox'>Firefox Mobile</a>";
                                    echo "</div>";
                                    echo "<div class='col s6'>";
                                        echo "<a href='https://mutaz.pro/download/?23'>Firefox Computer 64bit</a>";
                                        echo "<a href='https://mutaz.pro/download/?356'>Firefox Computer 32bit</a>";
                                    echo "</div>";
                                } else if ( $_GET["browser"] == "Safari" ) {
                                    echo "<div class='col s6'>";
                                        echo "<a href='https://apkpure.com/ar/surf-browser/com.gl9.cloudBrowser'>Safari Mobile</a>";
                                    echo "</div>";
                                    echo "<div class='col s6'>";
                                        echo "<a href='https://mutaz.pro/download/?22'>Safari Computer</a>";
                                    echo "</div>";
                                }
                            }
                        } else if ( isset($_GET["error"]) ) {
                            echo "<p class='center-align red-text'>" . $_GET["error"] . "</p>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    require $footer;
?>